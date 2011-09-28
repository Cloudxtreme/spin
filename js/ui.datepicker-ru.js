/* Russian (UTF-8) initialisation for the jQuery UI date picker plugin. */
/* Written by Andrew Stromnov (stromnov@gmail.com). */
jQuery(function($){
	$.datepicker.regional['ru'] = {
		closeText: 'закрыть',
		prevText: '<Пред',
		nextText: 'След>',
		currentText: 'РЎРµРіРѕРґРЅСЏ',
		monthNames: ['Январь','Февраль','Март','Апрель','Май','Июнь',
		'Июль','Август','Сентябрь','Октябрь','Ноябрь','Декабрь'],
		monthNamesShort: ['Январь','Февраль','Март','Апрель','Май','Июнь',
		'Июль','Август','Сентябрь','Октябрь','Ноябрь','Декабрь'],
		dayNames: ['воскресенье', 'понедельник','вторник','среда','четверг','пятница','суббота'],
		dayNamesShort: ['Вс', 'Пн','Вт','Ср','Чт','Пт','Сб'],
		dayNamesMin: ['Вс', 'Пн','Вт','Ср','Чт','Пт','Сб'],
		dateFormat: 'dd.mm.yy', firstDay: 1,
		isRTL: false};
	$.datepicker.setDefaults($.datepicker.regional['ru']);
});