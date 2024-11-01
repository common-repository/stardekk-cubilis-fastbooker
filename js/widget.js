jQuery(document).ready(function ($) {
  // Cubilis widget class
  function CubilisWidget(options) {
    // Define options
    this.element = 'element' in options ? options.element : null;
    this.config = null;
    this.datepicker = null;
    this.renderedWidth = $(window).width();
    // Initialize
    this.init();
  }
  
  // Extend Cubilis widget with init function
  CubilisWidget.prototype.init = function () {
    // Store class instance in variable
    var instance = this;
    // Check if an element is selected
    if (instance.element !== null || instance.element.length) {
      // Set config
      instance.insertConfig();
      // Render widget
      instance.render();
      // Add events
      instance.addEvents();
    }
  }
  
  // Extend Cubilis widget with config function
  CubilisWidget.prototype.insertConfig = function () {
    // Store class instance in variable
    var instance = this;
    // Set config options
    instance.config = {
      el: $(instance.element).find('.cubilis-fastbooker__calender')[0],
      startDateEl: $(instance.element).find('.cubilis-fastbooker__startDate')[0],
      endDateEl: $(instance.element).find('.cubilis-fastbooker__endDate')[0],
      startDateLabel: $(instance.element).find('.cubilis-fastbooker__startDateLabel')[0],
      endDateLabel: $(instance.element).find('.cubilis-fastbooker__endDateLabel')[0],
      locale: $(instance.element).attr('data-locale'),
      orientation: 'horizontal'
    };
    // Check for mobile devices
    if ($(window).width() < 670) {
      instance.config.orientation = 'vertical';
    }
  }
  
  // Extend Cubilis widget with render function
  CubilisWidget.prototype.render = function () {
    // Store class instance in variable
    var instance = this;
    // Check if config is filled in
    if (instance.config != null) {
      instance.datepicker = new CBPicker(instance.config);
    }
  }
  
  // Extend Cubilis widget with events function
  CubilisWidget.prototype.addEvents = function () {
    // Store class instance in variable
    var instance = this;
    // Calender open event
    $(instance.element).find('.cubilis-fastbooker__calender').click(function(e) {
      // Check if target is not the calender
      if (!$('.cb__calendar').is(e.target) && $('.cb__calendar').has(e.target).length === 0) {
        // Check if target is not the input field to prevent double trigger
        if (!$(e.target).is('.cubilis-fastbooker__startDateLabel') && !$(e.target).is('.cubilis-fastbooker__endDateLabel') && !$(e.target).is('.cubilis-fastbooker__startDate') && !$(e.target).is('.cubilis-fastbooker__endDate')) {
          $(instance.element).find('.cubilis-fastbooker__startDateLabel').trigger('click');
          e.preventDefault();
        }
      }
    })
    // Form submit event
    $(instance.element).submit(function(e) {
      e.preventDefault();
      var generalUrl = $(instance.element).data('general-url');
      var bookUrl = $(instance.element).data('book-url');
      var arrival = $(instance.element).find('.cubilis-fastbooker__startDate').val();
      var departure = $(instance.element).find('.cubilis-fastbooker__endDate').val();
      var discount = $(instance.element).find('.cubilis-fastbooker__discount').length ? $(instance.element).find('.cubilis-fastbooker__discount').val() : null;

      // Check if arrival and departure are filled in
      if (arrival.length > 0 && departure.length > 0) {
        // Make date
        arrival = new Date(arrival);
        departure = new Date(departure);
        // Date format
        var arrivalDate = arrival.getFullYear() + '-' + instance.composeDate(arrival.getMonth() + 1) + '-' + instance.composeDate(arrival.getDate());
        var departureDate = departure.getFullYear() + '-' + instance.composeDate(departure.getMonth() + 1) + '-' + instance.composeDate(departure.getDate());
        window.open(bookUrl + '&' + 'Arrival=' + arrivalDate + '&' + 'Departure=' + departureDate + (discount !== null && discount.length > 0 ? '&' +  'Discountcode=' + discount : ''), '_blank');
      } else {
        window.open(generalUrl, '_blank');
      }
    })
  }

  // Extend Cubilis widget with date formatting function
  CubilisWidget.prototype.composeDate = function(date) {
    date = date.toString();
    return date.length == 1 ? "0" + date : date;
  }

  // Select all DOM elements
  var $cubilisBookers = $('.cubilis-fastbooker .cubilis-fastbooker__form');
  // Initialize new cubilis widgets
  $cubilisBookers.each(function() {
    var $cubilisBooker = $(this);
    var cubilisWidget = new CubilisWidget({
      'element': $cubilisBooker,
    })
  });
})