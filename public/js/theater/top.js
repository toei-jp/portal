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
     * 劇場
     */
    movieTheater: undefined
};
$(function () {
    toei.API_ENDPOINT = $('input[name=API_ENDPOINT]').val();
    toei.THEATER_CODE = $('input[name=THEATER_CODE]').val();
    toei.WAITER_SERVER_URL = $('input[name=WAITER_SERVER_URL]').val();
    toei.TICKET_SITE_URL = $('input[name=TICKET_SITE_URL]').val();
    toei.PROJECT_ID = $('input[name=PROJECT_ID]').val();
    getMovieTheater().then(function (movieTheaters) {
        var findResult = movieTheaters.find(function (theater) {
            return (theater.location.branchCode === toei.THEATER_CODE);
        });
        if (findResult === undefined) {
            alert('劇場が見つかりません');
            return;
        }
        toei.movieTheater = findResult;
        createSchedule();
        createPreSchedule();
    }).catch(function (error) {
        alert('劇場一覧取得エラー');
    });
});

$(document).on('click', '.schedule-slider .swiper-slide a', selectDate);
$(document).on('click', '.pre-schedule-slider .swiper-slide a', selectDate);
$(document).on('click', '.change-schedule-button a', changeScheduleType);
$(document).on('click', '.performances li a', selectPerformances);

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
            320: {
                slidesPerView: 2.5
            },
            767: {
                slidesPerView: 3.5
            }
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
    return $.ajax(options);
}

/**
 * 設定作成
 * @param {string} accessToken 
 */
function createOptions(accessToken) {
    const option = {
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
        auth: auth
    }
}

/**
 * 劇場一覧取得
 */
function getMovieTheater() {
    var deferred = new $.Deferred;
    getCredentials()
        .then(function (credentials) {
            var accessToken = credentials.data.access_token;
            var options = createOptions(accessToken);
            var organizationService = new cinerino.service.Organization(options);
            return organizationService.searchMovieTheaters();
        }).then(function (movieTheatersResult) {
            var movieTheaters = movieTheatersResult.data;
            deferred.resolve(movieTheaters);
        }).catch(function (error) {
            console.error(error);
            deferred.reject(error);
        });
    return deferred.promise();
}

/**
 * 上映作品取得
 * @param {*} params
 */
function getScreeningEvent(params) {
    var deferred = new $.Deferred;
    toei.isRequest = true;
    getCredentials()
        .then(function (credentials) {
            var accessToken = credentials.data.access_token;
            var options = createOptions(accessToken);
            var eventService = new cinerino.service.Event(options);
            return eventService.searchScreeningEvents(params)
        }).then(function (screeningEventsResult) {
            toei.isRequest = false;
            var screeningEvents = screeningEventsResult.data;
            deferred.resolve(screeningEvents);
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
    var today = moment(moment().format('YYYYMMDD')).toISOString();
    var params = {
        eventStatuses: ['EventScheduled'],
        superEvent: {
            locationBranchCodes: toei.THEATER_CODE
        },
        startFrom: today,
        startThrough: moment(moment().add(10, 'day').format('YYYYMMDD')).toISOString(),
        offers: {
            availableFrom: today,
            availableThrough: today
        }
    };
    getScreeningEvent(params)
        .then(function (screeningEvents) {
            var dates = screeningEventToDate(screeningEvents);
            var domList = [];
            dates.forEach(function (date) {
                domList.push(createDateDom(date));
            });
            $('.schedule-slider .swiper-wrapper').append(domList.join('\n'));
            toei.scheduleSlider = createScheduleSlider();
            var today = moment(moment().format('YYYYMMDD')).toISOString();
            $('.schedule-slider .swiper-slide a[data-date="' + today + '"]').trigger('click');
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
    var today = moment(moment().format('YYYYMMDD')).toISOString();
    var activeClass = 'bg-orange text-white';
    var defaultClass = 'bg-yellow text-ultra-dark-gray'
    $('.schedule-slider .swiper-slide .bg-orange').removeClass(activeClass).addClass(defaultClass);
    $(this).removeClass(defaultClass).addClass(activeClass);
    $('.target-date').text(moment(date).format('YYYY/MM/DD(ddd)'));
    var params = {
        eventStatuses: ['EventScheduled'],
        superEvent: {
            locationBranchCodes: toei.THEATER_CODE
        },
        startFrom: date,
        startThrough: moment(moment(date).add(1, 'day').format('YYYYMMDD')).toISOString(),
        offers: {
            availableFrom: today,
            availableThrough: today
        }
    };
    getScreeningEvent(params)
        .then(function (screeningEvents) {
            toei.screeningEvents = screeningEvents;
            var films = screeningEventToFilm();
            var domList = [];
            films.forEach(function (film) {
                domList.push(createFilmDom(film));
            });
            $('.films').html(domList.join('\n'));
        }).catch(function (error) {
            alert('上映作品取得エラー');
        });;
}


/**
 * スケジュールから作品別へ変換
 */
function screeningEventToFilm() {
    var screeningEvents = toei.screeningEvents;
    var films = [];
    screeningEvents.forEach(function (screeningEvent) {
        const registered = films.find(function (film) {
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

    return films.sort(function (film1, film2) {
        if (film1.info.workPerformed.datePublished === undefined
            || film2.info.workPerformed.datePublished === undefined) {
            return 0;
        }
        const unixA = moment(film1.info.workPerformed.datePublished).unix();
        const unixB = moment(film2.info.workPerformed.datePublished).unix();
        if (unixA > unixB) {
            return -1;
        }
        if (unixA < unixB) {
            return 1;
        }
        return 0;
    });
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
            if (info.workPerformed.contentRating !== undefined) {
                return '<a href="http://www.eirin.jp/see/index.html" target="_blank" class="px-3 py-1 bg-ultra-dark-gray text-small text-white text-small text-center mr-2">' + info.workPerformed.contentRating + '</a>'
            }
            return '';
        })() + '\
        '+ (function () {
            if (info.superEvent.dubLanguage) {
                return '<div class="px-3 py-1 bg-ultra-dark-gray text-small text-white text-small text-center mr-2">吹替版</div>'
            }
            return '';
        })() + '\
        '+ (function () {
            if (info.superEvent.subtitleLanguage) {
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
        </ul >\
    </li > ';

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
        if (isNotOnlineSale) {
            return '<div>窓口</div>';
        }
        if (isNotStartSale) {
            return '<div>販売期間外</div>';
        }
        if (isEndSale) {
            return '<div>販売終了</div>';
        }
        if (performance.remainingAttendeeCapacity === undefined
            || performance.remainingAttendeeCapacity === 0) {
            return '<div>完売</div>';
        }
        if (performance.remainingAttendeeCapacity <= 10) {
            return '<div class="status-image"><img class="w-100" src="/images/icon/status_warning.svg"></div>\
            <div class="text-yellow">購入</div>';
        }
        if (performance.remainingAttendeeCapacity > 10) {
            return '<div class="status-image"><img class="w-100" src="/images/icon/status_success.svg"></div>\
            <div class="text-blue">購入</div>';
        }
        return '';
    })();
    var dom = '<li class="my-2">\
        <a class="mx-md-1 d-flex align-items-center d-md-block rounded border border-ultra-light-gray text-center p-2 ' + boxClassName + '" href="#" data-id="' + performance.id + '">\
            <div class="screen text-small mb-md-2 text-left text-md-center">' + performance.location.address.en + ' ' + performance.location.name.ja + '</div>\
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
    var today = moment(moment().format('YYYYMMDD')).toISOString();
    var now = moment().toDate();
    var params = {
        eventStatuses: ['EventScheduled'],
        superEvent: {
            locationBranchCodes: toei.THEATER_CODE
        },
        startFrom: moment(today).add(3, 'days').toDate(),
        offers: {
            validFrom: now,
            validThrough: now,
            availableFrom: now,
            availableThrough: now
        }
    };
    getScreeningEvent(params)
        .then(function (screeningEvents) {
            var dates = screeningEventToDate(screeningEvents);
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
            320: {
                slidesPerView: 2.5
            },
            767: {
                slidesPerView: 3.5
            }
        }
    };
    return new Swiper('.pre-schedule-slider .swiper-container', options);
}

/**
 * スケジュール切り替え
 */
function changeScheduleType(event) {
    event.preventDefault();
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
        scheduleSlider.find('.swiper-slide:first-child a').trigger('click');
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
 * パフォーマンス選択
 */
function selectPerformances(event) {
    event.preventDefault();
    var id = $(this).attr('data-id');
    var screeningEvents = toei.screeningEvents;
    var screeningEvent = screeningEvents.find(function (screeningEvent) {
        return (screeningEvent.id === id);
    });
    if (screeningEvent === undefined) {
        alert('スケジュールが見つかりません');
        return;
    }
    if (toei.WAITER_SERVER_URL === '') {
        location.href = toei.TICKET_SITE_URL + '/#/purchase/transaction/' + screeningEvent.id + '/' + data.token;
        return;
    }
    getPassport()
        .then(function (data) {
            location.href = toei.TICKET_SITE_URL + '/#/purchase/transaction/' + screeningEvent.id + '/' + data.token;
        }).catch(function (error) {
            var status = error.status;
            if (status === 429) {
                location.href = toei.TICKET_SITE_URL + '/#/congestion';
            } else if (status === 503) {
                location.href = toei.TICKET_SITE_URL + '/#/maintenance';
            } else {
                location.href = toei.TICKET_SITE_URL + '/#/error';
            }
        });

}

/**
 * パスポート取得
 */
function getPassport() {
    var selleId = toei.movieTheater.id;
    var url = toei.WAITER_SERVER_URL + '/projects/' + toei.PROJECT_ID + '/passports';
    var body = { scope: 'Transaction:PlaceOrder:' + selleId };
    var options = {
        dataType: 'json',
        url: url,
        type: 'POST',
        timeout: 10000,
        data: body
    };
    return $.ajax(options);
}
