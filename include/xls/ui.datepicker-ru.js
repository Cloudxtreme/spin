/* Russian (UTF-8) initialisation for the jQuery UI date picker plugin. */
/* Written by Andrew Stromnov (stromnov@gmail.com). */
jQuery(function($){
	$.datepicker.regional['ru'] = {
		closeText: '�������',
		prevText: '<����',
		nextText: '����>',
		currentText: 'Сегодня',
		monthNames: ['������','�������','����','������','���','����',
		'����','������','��������','�������','������','�������'],
		monthNamesShort: ['������','�������','����','������','���','����',
		'����','������','��������','�������','������','�������'],
		dayNames: ['�����������', '�����������','�������','�����','�������','�������','�������'],
		dayNamesShort: ['��', '��','��','��','��','��','��'],
		dayNamesMin: ['��', '��','��','��','��','��','��'],
		dateFormat: 'dd.mm.yy', firstDay: 1,
		isRTL: false};
	$.datepicker.setDefaults($.datepicker.regional['ru']);
});