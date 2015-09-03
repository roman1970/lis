/**
 * Created by Алексей on 07.11.2014.
 */

var calculatorSettings = {
    basePrice: 50,
    gender: [
        {
            alias: 'Женщины',
            rate: 1.3
        },
        {
            alias: 'Мужчины',
            rate: 1.4
        },
        {
            alias: 'Все',
            rate: 1,
			selected: true
        }
    ],
    region: [
        {
            alias: 'Вся Россия',
            rate: 0.1,
            selected: true
        },
        {
            alias: 'Москва',
            rate: 1
        },
        {
            alias: 'Санкт-Петербург',
            rate: 1
        },
		{
            alias: 'Новосибирск',
            rate: 1
        },
		{
            alias: 'Екатеринбург',
            rate: 1
        },
        {
            alias: 'Остальные',
            rate: 0.5
        }
    ],
    days: [
        {
            alias: 'Понедельник',
            rate: 0.3,
            selected: true
        },
        {
            alias: 'Вторник',
            rate: 0,
            selected: true
        },
        {
            alias: 'Среда',
            rate: 0,
            selected: true
        },
        {
            alias: 'Четверг',
            rate: 0,
            selected: true
        },
        {
            alias: 'Пятница',
            rate: 0,
            selected: true
        },
        {
            alias: 'Выходные',
            rate: 0.2
        }
    ],
    banner: [
        {
            alias: '728x90',
            rate: 0,
            selected: true
        },
        {
            alias: '240x400',
            rate: 0.4
        },
		  {
            alias: '160x600',
            rate: 0.5
        },
        {
            alias: '728x90 с расхлопом',
            rate: 0.3
        },
		  {
            alias: '160x600 с расхлопом',
            rate: 0.7
        },
        {
            alias: '240x400 с расхлопом',
            rate: 0.5
        }
    ],
    plattform: [
        {
            alias: 'Строительство',
            rate: 2.1
        },
        {
            alias: 'Женщины',
            rate: 0.2,
			selected: true
        },
        {
            alias: 'Медицина',
            rate: 1.1
        },
        {
            alias: 'Недвижимость',
            rate: 12.1
        },
        {
            alias: 'Беременность и роды',
            rate: 0.3
        }
    ],
    paymentType: [
        {
            alias: 'Предоплата',
            rate: 0,
            selected: true
        },
        {
            alias: 'Постоплата',
            rate: 0.5
        }
    ],
    VAT: [
        {
            alias: 'С НДС',
            rate: 0,
            selected: true
        },
        {
            alias: 'Без НДС',
            rate: 0
        }
    ]
};