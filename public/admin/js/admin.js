window.addEvent('domready', function() {
    
    MooTools.lang.setLanguage("pl-PL"); 


    new DatePicker($$('.date_picker'), {
        format: '%Y-%m-%d',
        allowEmpty: true,
        startView: 'days',
      //  timePicker: true,
      //  timeWheelStep: 5,
        pickerClass: 'datepicker_vista'
        
    });
   
    
});
 