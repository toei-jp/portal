var cinerino = window.cinerino;
var toei = {
    /**
     * APIエンドポイント
     */
    API_ENDPOINT: undefined,
    /**
     * 劇場コード
     */
    THEATER_CODE: undefined,
    /**
     * 流入制限URL
     */
    WAITER_SERVER_URL: undefined,
    /**
     * チケットサイトURL
     */
    TICKET_SITE_URL: undefined,
    /**
     * プロジェクトID
     */
    PROJECT_ID: undefined,
    /**
     * 先行販売表示判定
     */
    isDisplayPreSchedule: false,
    /**
     * スケジュールスライダー
     */
    scheduleSlider: undefined,
    /**
     * 先行販売スケジュールスライダー
     */
    preScheduleSlider: undefined,
    /**
     * 通信中判定
     */
    isRequest: false,
    /**
     * スケジュールデータ
     */
    screeningEvents: [],
    /**
     * 認証情報
     */
    credentials: undefined
};
$(function () {
    init();
    createSchedule();
    createPreSchedule();
});

$(document).on('click', '.schedule-slider .swiper-slide a', selectDate);
$(document).on('click', '.pre-schedule-slider .swiper-slide a', selectDate);
$(document).on('click', '.change-schedule-button button', changeScheduleType);

/**
 * 初期化
 */
function init() {
    toei.API_ENDPOINT = $('input[name=API_ENDPOINT]').val();
    toei.THEATER_CODE = $('input[name=THEATER_CODE]').val();
    toei.WAITER_SERVER_URL = $('input[name=WAITER_SERVER_URL]').val();
    toei.TICKET_SITE_URL = $('input[name=TICKET_SITE_URL]').val();
    toei.PROJECT_ID = $('input[name=PROJECT_ID]').val();
}

/**
 * スケジュールスライダー作成
 */
function createScheduleSlider() {
    var options = {
        spaceBetween: 3,
        freeMode: true,
        slidesPerView: 7,
        navigation: {
            nextEl: '.schedule-slider .swiper-button-next',
            prevEl: '.schedule-slider .swiper-button-prev',
        },
        breakpoints: {
            320: { slidesPerView: 2.5 },
            767: { slidesPerView: 3.5 }
        }
    };
    return new Swiper('.schedule-slider .swiper-container', options);
}

/**
 * 認証情報取得
 */
function getCredentials() {
    var options = {
        dataType: 'json',
        url: '/api/auth/token',
        type: 'POST',
        timeout: 10000
    };
    var deferred = new $.Deferred;
    if (toei.credentials === undefined
        || moment(toei.credentials.expired).unix() < moment().unix()) {
        $.ajax(options).then(function (credentials) {
            toei.credentials = {
                accessToken: credentials.data.access_token,
                expired: moment().add(credentials.data.expires_in, 'second').add(-5, 'minutes').toISOString()
            };
            deferred.resolve(toei.credentials.accessToken);
        }).catch(function (error) {
            deferred.reject(error);
        });
    } else {
        deferred.resolve(toei.credentials.accessToken);
    }
    return deferred.promise();
}

/**
 * 設定作成
 * @param {string} accessToken 
 */
function createOptions(accessToken) {
    var option = {
        domain: '',
        clientId: '',
        redirectUri: '',
        logoutUri: '',
        responseType: '',
        scope: '',
        state: '',
        nonce: null,
        tokenIssuer: ''
    };
    var auth = cinerino.createAuthInstance(option);
    auth.setCredentials({ accessToken: accessToken });

    return {
        endpoint: toei.API_ENDPOINT,
        auth: auth,
        project: { id: toei.PROJECT_ID }
    }
}

/**
 * 上映作品取得
 * @param {*} params
 */
function getScreeningEvent(params, sort) {
    var deferred = new $.Deferred;
    toei.isRequest = true;
    var screeningEvents = [];
    var screeningEventSeries = [];
    var options;
    var eventService;
    getCredentials()
        .then(function (accessToken) {
            options = createOptions(accessToken);
            eventService = new cinerino.service.Event(options);
            // TODO 100件制限
            return eventService.search(params)
        }).then(function (result) {
            screeningEvents = result.data;
            if (!sort) {
                toei.isRequest = false;
                deferred.resolve(screeningEvents);
                return;
            }
            // 施設コンテンツ追加特性sortNumberでソート
            var workPerformedIdentifiers = [];
            screeningEvents.forEach(function (s) {
                var _a;
                if (((_a = s.workPerformed) === null || _a === void 0 ? void 0 : _a.identifier) === undefined
                    || workPerformedIdentifiers.find(function (id) { var _a; return id === ((_a = s.workPerformed) === null || _a === void 0 ? void 0 : _a.identifier); }) !== undefined) {
                    return;
                }
                workPerformedIdentifiers.push(s.workPerformed.identifier);
            });
            eventService.search({
                typeOf: 'ScreeningEventSeries',
                location: { branchCodes: params.superEvent.locationBranchCodes },
                workPerformed: { identifiers: workPerformedIdentifiers }
            }).then(function (result2) {
                screeningEventSeries = result2.data;
                var sortResult = sortScreeningEvents(screeningEvents, screeningEventSeries);
                toei.isRequest = false;
                deferred.resolve(sortResult);
            }).catch(function (error2) {
                toei.isRequest = false;
                console.error(error2);
                deferred.reject(error2);
            });
        }).catch(function (error) {
            toei.isRequest = false;
            console.error(error);
            deferred.reject(error);
        });
    return deferred.promise();
}

/**
 * スケジュール作成
 */
function createSchedule() {
    var today = moment(moment().format('YYYYMMDD')).toDate();
    var now = moment().toDate();
    var params = {
        typeOf: 'ScreeningEvent',
        eventStatuses: ['EventScheduled'],
        superEvent: { locationBranchCodes: [toei.THEATER_CODE] },
        startFrom: today,
        startThrough: moment(moment().add(10, 'day').format('YYYYMMDD')).toDate(),
        offers: {
            availableFrom: now,
            availableThrough: now
        }
    };
    getScreeningEvent(params, false)
        .then(function (screeningEvents) {
            var dates = screeningEventToDate(screeningEvents);
            var domList = [];
            dates.forEach(function (date) {
                domList.push(createDateDom(date));
            });
            $('.schedule-slider .swiper-wrapper').append(domList.join('\n'));
            toei.scheduleSlider = createScheduleSlider();
            var target = dates.find(function (d) {
                return (d.data !== undefined);
            });
            if (target === undefined) {
                return;
            }
            var selectedDate = sessionStorage.getItem('selectedDate');
            if ($('.schedule-slider .swiper-slide a[data-date="' + selectedDate + '"]').length > 0) {
                $('.schedule-slider .swiper-slide a[data-date="' + selectedDate + '"]').trigger('click');
                return;
            }
            $('.schedule-slider .swiper-slide a[data-date="' + target.date + '"]').trigger('click');
        }).catch(function (error) {
            alert('上映作品取得エラー');
        });
}

/**
 * スケジュールから日付へ変換
 */
function screeningEventToDate(screeningEvents) {
    var results = [];
    var limitDate = 10;
    for (var i = 0; i < limitDate; i++) {
        var date = moment(moment().format('YYYYMMDD')).add(i, 'day').toISOString();
        results.push({ date: date })
    }
    results.forEach(function (result) {
        var findResult = screeningEvents.find(function (screeningEvent) {
            return moment(result.date).format('YYYYMMDD') === moment(screeningEvent.startDate).format('YYYYMMDD');
        });
        result.data = findResult;
    });

    return results;
}

/**
 * 先行販売スケジュールから日付へ変換
 */
function preScreeningEventToDate(screeningEvents) {
    var results = [];
    screeningEvents.forEach(function (screeningEvent) {
        var date = moment(moment(screeningEvent.startDate).format('YYYYMMDD')).toISOString();
        if (results.find(function (result) { return (result.date === date); }) === undefined) {
            results.push({ date: date });
        }
    });
    results.forEach(function (result) {
        var findResult = screeningEvents.find(function (screeningEvent) {
            return moment(result.date).format('YYYYMMDD') === moment(screeningEvent.startDate).format('YYYYMMDD');
        });
        result.data = findResult;
    });

    return results;
}

/**
 * スケジュールHTML作成
 */
function createDateDom(date) {
    var data = date.data;
    var date = date.date;
    var month = moment(date).format('MM');
    var day = moment(date).format('DD');
    var week = moment(date).format('ddd');
    var className = (data === undefined) ? 'bg-gray text-super-light-gray not-event' : 'bg-yellow text-ultra-dark-gray';
    var dom = '<div class="swiper-slide">\
        <a href="#" data-date="' + date + '" class="d-block ' + className + '">\
            <div class="position-absolute d-flex align-items-center justify-content-center">\
                <div class="text-large">' + month + '/<strong class="text-x-large">' + day + '</strong>(' + week + ')</div>\
            </div>\
        </a>\
    </div>';

    return dom;
}

/**
 * スケジュール選択
 */
function selectDate(event) {
    event.preventDefault();
    if (toei.isRequest) {
        return;
    }
    if ($(this).hasClass('bg-ultra-light-gray')) {
        return;
    }
    var date = $(this).attr('data-date');
    var today = moment(moment().format('YYYYMMDD')).toDate();
    var now = moment().toDate();
    var activeClass = 'bg-orange text-white';
    var defaultClass = 'bg-yellow text-ultra-dark-gray'
    $('.schedule-slider .swiper-slide .bg-orange')
        .removeClass(activeClass)
        .addClass(defaultClass);
    $('.pre-schedule-slider .swiper-slide .bg-orange')
        .removeClass(activeClass)
        .addClass(defaultClass);
    $(this).removeClass(defaultClass).addClass(activeClass);
    $('.target-date').text(moment(date).format('YYYY/MM/DD(ddd)'));
    $('.change-schedule-button button').prop('disabled', true);
    var scheduleDate = moment(date).format('YYYYMMDD');
    var params = {
        typeOf: 'ScreeningEvent',
        eventStatuses: ['EventScheduled'],
        superEvent: { locationBranchCodes: [toei.THEATER_CODE] },
        startFrom: date,
        startThrough: moment(scheduleDate).add(1, 'day').add(-1, 'millisecond').toDate(),
        offers: {
            availableFrom: now,
            availableThrough: now,
            validFrom: (toei.isDisplayPreSchedule) ? now : undefined,
            validThrough: (toei.isDisplayPreSchedule) ? now : undefined,
        }
    };
    getScreeningEvent(params, true)
        .then(function (screeningEvents) {
            sessionStorage.setItem('selectedDate', date);
            toei.screeningEvents = screeningEvents;
            var films = screeningEventToFilm();
            var domList = [];
            films.forEach(function (film) {
                domList.push(createFilmDom(film));
            });
            $('.films').html(domList.join('\n'));
            $('.change-schedule-button button').prop('disabled', false);
        }).catch(function (error) {
            alert('上映作品取得エラー');
            $('.change-schedule-button button').prop('disabled', false);
        });
}


/**
 * スケジュールから作品別へ変換
 */
function screeningEventToFilm() {
    var screeningEvents = toei.screeningEvents;
    var films = [];
    screeningEvents.forEach(function (screeningEvent) {
        var registered = films.find(function (film) {
            return (film.info !== undefined
                && film.info.superEvent.id === screeningEvent.superEvent.id);
        });
        if (registered === undefined) {
            films.push({
                info: screeningEvent,
                data: [screeningEvent]
            });
        } else {
            registered.data.push(screeningEvent);
        }
    });

    return films;
}

/**
 * 作品HTML作成
 */
function createFilmDom(film) {
    var info = film.info;
    var dom = '<li class="p-3 mb-3 bg-super-light-orange">\
        <div class="mb-3">\
        <p class="mb-0"><strong>' + info.name.ja + '</strong></p>\
        '+ (function () {
            if (info.workPerformed.headline !== undefined) {
                return '<p class="mb-0">' + info.workPerformed.headline + '</p>'
            }
            return '';
        })() + '\
        '+ (function () {
            if (info.superEvent.description !== undefined
                && info.superEvent.description.ja !== undefined) {
                return '<p class="mb-0">' + info.superEvent.description.ja + '</p>'
            }
            return '';
        })() + '\
        </div>\
        <div class="d-flex align-items-center mb-3">\
        '+ (function () {
            if (info.workPerformed.contentRating !== undefined
                && info.workPerformed.contentRating !== null) {
                return '<a href="http://www.eirin.jp/see/index.html" target="_blank" class="px-3 py-1 bg-ultra-dark-gray text-small text-white text-small text-center mr-2">' + info.workPerformed.contentRating + '</a>'
            }
            return '';
        })() + '\
        '+ (function () {
            if (info.superEvent.dubLanguage !== undefined
                && info.superEvent.dubLanguage !== null
                && info.superEvent.dubLanguage !== '') {
                return '<div class="px-3 py-1 bg-ultra-dark-gray text-small text-white text-small text-center mr-2">吹替版</div>'
            }
            return '';
        })() + '\
        '+ (function () {
            if (info.superEvent.subtitleLanguage
                && info.superEvent.subtitleLanguage !== null
                && info.superEvent.subtitleLanguage !== '') {
                return '<div class="px-3 py-1 bg-ultra-dark-gray text-small text-white text-small text-center mr-2">字幕版</div>'
            }
            return '';
        })() + '\
            <div class="text-small ml-auto">上映時間：'+ moment.duration(info.workPerformed.duration).asMinutes() + '分</div>\
        </div>\
        <ul class="performances d-md-flex flex-wrap">\
        '+ (function () {
            var performances = [];
            film.data.forEach(function (performance) {
                performances.push(createPerformanceDom(performance));
            });
            return performances.join('\n');
        })() + '\
        </ul>\
    </li> ';

    return dom;
}

/**
 * パフォーマンスHTML作成
 */
function createPerformanceDom(performance) {
    var now = moment();
    var isNotOnlineSale = (moment(performance.offers.validFrom) < now
        && moment(performance.startDate).add(-20, 'minutes').unix() <= moment().unix())
        && moment(performance.offers.validThrough) >= now;
    var isNotStartSale = (performance.offers === undefined) ? false : moment(performance.offers.validFrom) > now;
    var isEndSale = (performance.offers === undefined) ? false : moment(performance.offers.validThrough) < now;
    var isSale = !(isNotOnlineSale
        || isNotStartSale
        || isEndSale
        || performance.remainingAttendeeCapacity === undefined
        || performance.remainingAttendeeCapacity === 0);
    var boxClassName = (isSale) ? 'bg-white text-ultra-dark-gray' : 'bg-super-dark-gray text-super-light-gray not-event';
    var borderClassName = (isSale) ? 'bg-ultra-light-gray' : 'bg-white';
    var status = (function () {
        if (isNotStartSale) {
            return '<div>販売期間外</div>';
        } else if (isEndSale) {
            return '<div>販売終了</div>';
        } else if (performance.remainingAttendeeCapacity === undefined
            || performance.maximumAttendeeCapacity === undefined) {
            return '<div>販売期間外</div>';
        } else if (performance.remainingAttendeeCapacity === 0) {
            return '<div>完売</div>';
        } else if (isNotOnlineSale) {
            if (Math.floor(performance.remainingAttendeeCapacity / performance.maximumAttendeeCapacity * 100) < 30) {
                return '<div class="status-image"><img class="w-100" src="/images/icon/status_warning_window.svg"></div>\
                <div>窓口</div>';
            } else {
                return '<div class="status-image"><img class="w-100" src="/images/icon/status_success_window.svg"></div>\
                <div>窓口</div>';
            }
        } else if (Math.floor(performance.remainingAttendeeCapacity / performance.maximumAttendeeCapacity * 100) < 30) {
            return '<div class="status-image"><img class="w-100" src="/images/icon/status_warning.svg"></div>\
            <div class="text-yellow">購入</div>';
        } else {
            return '<div class="status-image"><img class="w-100" src="/images/icon/status_success.svg"></div>\
            <div class="text-blue">購入</div>';
        }
    })();
    // var ticketSite = toei.TICKET_SITE_URL + '?performanceId=' + performance.id + '" data-id="' + performance.id;
    var ticketSite = toei.TICKET_SITE_URL + '/projects/' + toei.PROJECT_ID + '/purchase/transaction/' + performance.id;
    var dom = '<li class="my-2">\
        <a class="h-100 mx-md-1 d-flex align-items-center d-md-block rounded border border-ultra-light-gray text-center p-2 ' + boxClassName + '" href="' + ticketSite + '">\
            <div class="screen text-small mb-md-2 text-left text-md-center">\
            '+ (function () {
            if (performance.location.address !== undefined) {
                return performance.location.address.en + ' ' + performance.location.name.ja
            }
            return performance.location.name.ja;
        })() + '\
            </div>\
            <div class="mx-auto"><strong class="text-x-large">' + moment(performance.startDate).format('HH:mm') + '</strong>-' + moment(performance.endDate).format('HH:mm') + '</div>\
            <hr class="d-none d-md-block my-2 border-0 ' + borderClassName + '">\
            <div class="status d-flex justify-content-around align-items-center">\
                '+ status + '\
            </div>\
        </a>\
    </li>';

    return dom;
}

/**
 * 先行販売スケジュール作成
 */
function createPreSchedule() {
    var today = moment(moment().format('YYYYMMDD')).toDate();
    var now = moment().toDate();
    var params = {
        typeOf: 'ScreeningEvent',
        eventStatuses: ['EventScheduled'],
        superEvent: { locationBranchCodes: [toei.THEATER_CODE] },
        startFrom: moment(today).add(3, 'days').toDate(),
        offers: {
            validFrom: now,
            validThrough: now,
            availableFrom: now,
            availableThrough: now
        }
    };
    getScreeningEvent(params, false)
        .then(function (screeningEvents) {
            var dates = preScreeningEventToDate(screeningEvents);
            var filterResult = dates.filter(function (date) {
                return date.data !== undefined;
            });
            if (filterResult.length === 0) {
                return;
            }
            var domList = [];
            filterResult.forEach(function (date) {
                domList.push(createDateDom(date));
            });
            $('.pre-schedule-slider .swiper-wrapper').append(domList.join('\n'));
            toei.preScheduleSlider = createPreScheduleSlider();
            $('.change-schedule-button').removeClass('d-none');
        }).catch(function (error) {
            alert('上映作品取得エラー');
        });;
}

/**
 * 先行販売スケジュールスライダー作成
 */
function createPreScheduleSlider() {
    var options = {
        speed: 500,
        spaceBetween: 3,
        freeMode: true,
        slidesPerView: 7,
        navigation: {
            nextEl: '.pre-schedule-slider .swiper-button-next',
            prevEl: '.pre-schedule-slider .swiper-button-prev',
        },
        breakpoints: {
            320: { slidesPerView: 2.5 },
            767: { slidesPerView: 3.5 }
        }
    };
    return new Swiper('.pre-schedule-slider .swiper-container', options);
}

/**
 * スケジュール切り替え
 */
function changeScheduleType() {
    var sliderClassName = 'd-none';
    var scheduleSlider = $('.schedule-slider');
    var preScheduleSlider = $('.pre-schedule-slider');
    var scheduleButton = $('.change-schedule-button .bg-super-dark-gray');
    var preScheduleButton = $('.change-schedule-button .bg-orange');
    if (toei.isDisplayPreSchedule) {
        // 通常スケジュール表示へ
        preScheduleSlider.addClass(sliderClassName);
        scheduleSlider.removeClass(sliderClassName);
        toei.isDisplayPreSchedule = false;
        toei.scheduleSlider.update();
        preScheduleButton.removeClass('d-none').addClass('d-block');
        scheduleButton.removeClass('d-block').addClass('d-none');
        var target;
        scheduleSlider.find('.swiper-slide').each(function (i, e) {
            if (target === undefined && $(e).find('.bg-yellow').length > 0) {
                target = $(e);
                return;
            }
        });
        if (target === undefined) {
            return;
        }
        target.find('a').trigger('click');
    } else {
        // 先行スケジュール表示へ
        scheduleSlider.addClass(sliderClassName);
        preScheduleSlider.removeClass(sliderClassName);
        toei.isDisplayPreSchedule = true;
        toei.preScheduleSlider.update();
        scheduleButton.removeClass('d-none').addClass('d-block');
        preScheduleButton.removeClass('d-block').addClass('d-none');
        preScheduleSlider.find('.swiper-slide:first-child a').trigger('click');
    }
}

/**
 * スケジュールをソート
 */
function sortScreeningEvents(screeningEvents, screeningEventSeries) {
    var sortResult = screeningEvents.sort(function (a, b) {
        var _a, _b, _c, _d, _e, _f;
        var KEY_NAME = 'sortNumber';
        var sortNumberA = (_c = (_b = (_a = screeningEventSeries
            .find(function (s) { return s.id === a.superEvent.id; })) === null || _a === void 0 ? void 0 : _a.additionalProperty) === null || _b === void 0 ? void 0 : _b.find(function (p) { return p.name === KEY_NAME; })) === null || _c === void 0 ? void 0 : _c.value;
        var sortNumberB = (_f = (_e = (_d = screeningEventSeries
            .find(function (s) { return s.id === b.superEvent.id; })) === null || _d === void 0 ? void 0 : _d.additionalProperty) === null || _e === void 0 ? void 0 : _e.find(function (p) { return p.name === KEY_NAME; })) === null || _f === void 0 ? void 0 : _f.value;
        if (sortNumberA === undefined) {
            return 1;
        }
        if (sortNumberB === undefined) {
            return -1;
        }
        if (Number(sortNumberA) > Number(sortNumberB)) {
            return -1;
        }
        if (Number(sortNumberA) < Number(sortNumberB)) {
            return 1;
        }
        return 0;
    });

    return sortResult;
}
