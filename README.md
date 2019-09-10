# huvepharma

Разработаны скрипты для Битрикс 24
Подключение дополнительной вкладки к компании "История визитов", перечеркивание выполненных задач в календаре. 

## Чтобы работала задача по перечеркиванию выполненных задач в календаре, нужно поменять две строчки в нескольких файлах
### Со временем Битрикс 24 будет обновляться и эти изменения в ядре могут быть затерты
1) /bitrix/js/calendar/new/calendar-view-month.js

        partWrap = BX.create('DIV', {
            attrs: {'data-bx-calendar-entry': entry.uid, 'status': entry.data.STATUS},
            props: {className: entryClassName}, style: {
            top: 0,
            left: 'calc((100% / ' + this.dayCount + ') * (' + (from.dayOffset + 1) + ' - 1) + 2px)',
            width: 'calc(' + daysCount + ' * 100% / ' + this.dayCount + ' - ' + deltaPartWidth + 'px)'
            }
        });

2) /bitrix/modules/calendar/classes/general/calendar.php - класс календаря
В конце функции getTaskList(), нужно в результирующий массив добавить STATUS

        $res[] = array(
                    "ID" => $task["ID"],
                    "~TYPE" => "tasks",
                    "NAME" => $task["TITLE"],
                    "DATE_FROM" => $dtFrom,
                    "DATE_TO" => $dtTo,
                    "DT_SKIP_TIME" => $skipTime ? 'Y' : 'N',
                    "CAN_EDIT" => CTasks::CanCurrentUserEdit($task),
                    "STATUS"    => $task["STATUS"]
                );


## Отлавливаем event

    BX.addCustomEvent('onEntityDetailsTabShow', function (currentTab) {
    // Тут можно описать собственную логику

    // var test = currentTab;
    console.log(currentTab._data.id);


    if ( currentTab._data.id === "tab_rest_2" ) {

        var content = $('tab_rest_2');

            BX.ajax({
                    url: '/local/task/test.php',
                    method: 'POST',
                    dataType: 'html',
                    onsuccess: function(data)
                    {
                        content.innerHTML = data;
                        BX.closeWait($this, waiter);
                    },
                    onfailure: function(data)
                    {
                        BX.closeWait(innerTab, waiter);
                    }
                }
            );
    }


});


## Добавление табов


    $(document).ready(function () {

        // Слушаем события
        // BX.addCustomEvent("SidePanel.Slider:onLoad",function () {
        //
        //      if ( matches = this.iframeSrc.match(/\/crm\/company\/details\/([\d]+)\//i)) {
        //
        //         var checkExist = setInterval(function() {
        //
        //             if ( top.window.frames !== undefined ) {
        //
        //                 //console.log(this.frames.BX.Crm.EntityDetailManager.items);
        //             } else {
        //                 //console.log('Searching...');
        //             }
        //         }, 1000);
        //
        //     }
        // });






    if ( matches = window.location.href.match(/\/crm\/company\/details\/([\d]+)\//i)) {
        addTab(matches);
    }

    function addTab(matches) {

        var tabName = "";

        var companyId = parseInt(matches[1]);

        console.log(companyId);

        if (companyId > 0) {

            //$("#company_"+companyId+"_details_tabs_menu").append(' <li data-tab-id="tab_rest_3" class="crm-entity-section-tab"> <a class="crm-entity-section-tab-link" href="#">История визитов 2</a> </li>');;

            // К сожалению менеджер карточки не генерирует никаких событий при инициализации
            // так что сложно определить когда он проинициализирован.
            // Поэтому будем проверять каждую секунду его наличие
            (new Promise(function (resolve, reject) {
                // Объявим переменную в которой будем хранить количество попыток
                var checkTabManagerCount = 0;

                // Объявим рекурсивную функцию для моиска менеджера карточки
                var checkTabManager = function () {

                    console.log(checkTabManagerCount);

                    // Если за 20 попыток не удалось найти менеджер карточки значит что-то пошло не так
                    if (20 < ++checkTabManagerCount) {
                        return reject();
                    }

                    // Сформируем идентификатор карточки
                    var detailId = ["company", companyId, 'details'].join('_');

                    // Попробуем получить менеджер карточки по ее идентификатору
                    var detailManager = BX.Crm.EntityDetailManager.items[detailId];

                    // Если не получилось возможно это повторный лид или сделка
                    if (!detailManager) {
                        detailManager = BX.Crm.EntityDetailManager.items['returning_' + detailId];
                    }

                    // Если менеджер не найден значит он еще не проинициализирован
                    if (!detailManager) {
                        return setTimeout(checkTabManager, 1000);
                    }

                    // Успех вернем менеджер вкладок
                    return resolve(detailManager._tabManager)
                };

                // Запустим поиск менеджера карточки
                checkTabManager();
            })).then(
                function (tabManager) {
                    // Сформируем параметры вкладки
                    var tabData = {};

                    // Идентификатор вкладки
                    tabData.id = 'visits_history';

                    // Наименование вкладки
                    tabData.name = 'История визитов';

                    // Контент вкладки, если мы хотим чтобы во вкладке был статичный контент передаем его сюда, можно через параметры функции, в противном случае данный параметр можно опустить
                    //tabData.html = '<div style="color: green">Foo tab content</div>';

                    // Создадим html узел отвечающий за контент вкладки
                    var tabContainer = BX.create(
                        'div',
                        {
                            attrs: {
                                className: 'crm-entity-section crm-entity-section-info crm-entity-section-above-overlay crm-entity-section-tab-content-hide',
                            },
                            dataset: {
                                'tabId': tabData.id,
                            },
                            html: tabData.html,
                        }
                    );

                    // Добавим созданный контейнер к остальным контейнерам вкладок
                    BX.append(
                            tabContainer,
                            tabManager._container
                        );

                        // Создадим html узел отвечающий за кнопку вкладки в меню навигации карточки
                        var tabMenuContainer = BX.create(
                            'div',
                            {
                                attrs: {
                                    className: 'crm-entity-section-tab',
                                },
                                dataset: {
                                    tabId: tabData.id,
                                },
                                html: '<a class="crm-entity-section-tab-link" href="#">' + tabData.name + '</a>',
                            }
                        );

                        // Добавим созданный пункт меню к остальным пунктам меню
                        BX.append(
                            tabMenuContainer,
                            tabManager._menuContainer
                        );

                        // Если мы хотим подгружать контент вкладки динамически то опишем как надо это делать
                        tabData.loader = {};

                        // Адрес на который будет делаться запрос при первом показе вкладки
                        //tabData.loader.serviceUrl = '/bitrix/components/bitrix/crm.event.view/lazyload.ajax.php?&sites1&sessid='+BX.message('bitrix_sessid');
                        tabData.loader.serviceUrl = '/local/components/1cbit/crm.history.events/history.ajax.php?&site=s1&sessid='+BX.message('bitrix_sessid');
                        //tabData.loader.serviceUrl = '/history/';

                        // Параметры которые будут отправлены в ajax запросе, параметры передаются в массиве PARAMS
                        tabData.loader.componentData = {companyId: companyId};

                        // Контейнер в который будет вставлен ответ сервера
                        tabData.loader.container = tabContainer;

                        // Идентификатор вкладки, так же попадет в массив PARAMS
                        tabData.loader.tabId = tabData.id;

                        // Добавим новую вкладку в менеджер вкладок
                        tabManager._items.push(
                            BX.Crm.EntityDetailTab.create(
                                tabData.id,
                                {
                                    manager: tabManager,
                                    data: tabData,
                                    container: tabContainer,
                                    menuContainer: tabMenuContainer,
                                }
                            )
                        );
                    },
                    function () {
                        // Если не удалось найти менеджер вкладок можно вывести уведомление
                    }
                );


            }

        }

    });
