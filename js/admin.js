(function($) {

  // Cubilis admin class
  function CubilisAdmin(options) {
    // Define options
    this.colorPickers = 'colorPickers' in options ? options.colorPickers : null;
    this.isLooping = false;
    // Initialize
    this.init();
  }

  // Extend Cubilis admin with init function
  CubilisAdmin.prototype.init = function () {
    // Store class instance in variable
    var instance = this;
    // Check if there are any color pickers
    if (instance.colorPickers !== null || instance.colorPickers.length > 0) {
      // Render color pickers
      instance.render();
      // Add event on wordpress save
      $('input[type=submit]').click(function() {
        instance.onsubmit();
      })
    }
  }

  // Extend Cubilis admin with render function
  CubilisAdmin.prototype.render = function() {
    // Store class instance in variable
    var instance = this;
    // Loop over all color picker instances
    $(instance.colorPickers).each(function() {
      // Store color picker instance in variable
      var colorPicker = this;
      // Create color picker
      $(colorPicker).spectrum({
        allowEmpty: false,
        showAlpha: false,
        showInput: true,
        showButtons: false,
        preferredFormat: 'hex',
        move: function(color) {
          // Update input on color picker change
          $(colorPicker).val(color.toHexString());
          // Update wordpress save button, because wordpress doesn't detect change from color picker
          $(colorPicker).closest('.widget').find('input[type=submit]').attr('disabled', false);
        },
        change: function(color) {
          // Update wordpress save button, because wordpress doesn't detect change from color picker
          $(colorPicker).closest('.widget').find('input[type=submit]').attr('disabled', false);
        } 
      });
      // Update color picker on input change
      $(colorPicker).on('change', function() {
        $(colorPicker).spectrum('set', $(colorPicker).val());
      });
      // Set data attribute to false
      $('.cubilis-fastbooker').attr('data-new-render', false);
    })
  }

  // Extend Cubilis admin with submit function
  CubilisAdmin.prototype.onsubmit = function() {
    // Store class instance in variable
    var instance = this;
    // Start recursive render
    instance.recursiveRender();
  }

  // Extend Cubilis admin with recursive rendering function
  CubilisAdmin.prototype.recursiveRender = function() {
    // Store class instance in variable
    var instance = this;
    // Cet data attribute from DOM
    var isNewRender = false;
    $('.cubilis-fastbooker').each(function () {
      if ($(this).attr('data-new-render').toString() === "true") {
        isNewRender = true;
      }
    });
    // Check if DOM got updated
    if (isNewRender) {
      // Re-render color pickers
      instance.render();
    } else {
      // Re-try after short pause
      setTimeout(function () {
        instance.recursiveRender();
      }, 200);
    }
  }

  // Initialize new cubilis admin
  var cubilisAdmin = new CubilisAdmin({
    'colorPickers': '.cubilis-fastbooker-color',
  })

})(jQuery);