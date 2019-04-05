$(function() {
    // Remove button click
    $(document).on(
        'click',
        '[data-role="dynamic-fields"] > .form-inline [data-role="remove"]',
        function(e) {
            e.preventDefault();
            $(this).closest('.form-inline').remove();
        }
    );
    // Add button click
    $(document).on(
        'click',
        '[data-role="dynamic-fields"] > .form-inline [data-role="add"]',
        function(e) {
            e.preventDefault();
            var container = $(this).closest('[data-role="dynamic-fields"]');
            new_field_group = container.children().filter('.form-inline:first-child').clone();
            new_field_group.find('input').each(function(){
                $(this).val('');
            });
            container.append(new_field_group);
        }
    );
});

$(function() {
    // Remove button click
    $(document).on(
        'click',
        '[data-role="dynamic-fields2"] > .form-inline [data-role="remove"]',
        function(e) {
            e.preventDefault();
            $(this).closest('.form-inline').remove();
        }
    );
    // Add button click
    $(document).on(
        'click',
        '[data-role="dynamic-fields2"] > .form-inline [data-role="add"]',
        function(e) {
            e.preventDefault();
            var container = $(this).closest('[data-role="dynamic-fields2"]');
            new_field_group = container.children().filter('.form-inline:first-child').clone();
            new_field_group.find('input').each(function(){
                $(this).val('');
            });
            container.append(new_field_group);
        }
    );
});


$(function() {
    // Remove button click
    $(document).on(
        'click',
        '[data-role="dynamic-fields1"] > .form-inline [data-role="remove"]',
        function(e) {
            e.preventDefault();
            $(this).closest('.form-inline').remove();
        }
    );
    // Add button click
    $(document).on(
        'click',
        '[data-role="dynamic-fields1"] > .form-inline [data-role="add"]',
        function(e) {
            e.preventDefault();
            var container = $(this).closest('[data-role="dynamic-fields1"]');
            new_field_group = container.children().filter('.form-inline:first-child').clone();
            new_field_group.find('input').each(function(){
                $(this).val('');
            });
            container.append(new_field_group);
        }
    );
});



$(function() {
    // Remove button click
    $(document).on(
        'click',
        '[data-role="dynamic-fields3"] > .form-inline [data-role="remove"]',
        function(e) {
            e.preventDefault();
            $(this).closest('.form-inline').remove();
        }
    );
    // Add button click
    $(document).on(
        'click',
        '[data-role="dynamic-fields3"] > .form-inline [data-role="add"]',
        function(e) {
            e.preventDefault();
            var container = $(this).closest('[data-role="dynamic-fields3"]');
            new_field_group = container.children().filter('.form-inline:first-child').clone();
            new_field_group.find('input').each(function(){
                $(this).val('');
            });
            container.append(new_field_group);
        }
    );
});



$(function() {
    // Remove button click
    $(document).on(
        'click',
        '[data-role="dynamic-fields4"] > .form-inline [data-role="remove"]',
        function(e) {
            e.preventDefault();
            $(this).closest('.form-inline').remove();
        }
    );
    // Add button click
    $(document).on(
        'click',
        '[data-role="dynamic-fields4"] > .form-inline [data-role="add"]',
        function(e) {
            e.preventDefault();
            var container = $(this).closest('[data-role="dynamic-fields4"]');
            new_field_group = container.children().filter('.form-inline:first-child').clone();
            new_field_group.find('input').each(function(){
                $(this).val('');
            });
            container.append(new_field_group);
        }
    );
});



$(function() {
    // Remove button click
    $(document).on(
        'click',
        '[data-role="dynamic-fields5"] > .form-inline [data-role="remove"]',
        function(e) {
            e.preventDefault();
            $(this).closest('.form-inline').remove();
        }
    );
    // Add button click
    $(document).on(
        'click',
        '[data-role="dynamic-fields5"] > .form-inline [data-role="add"]',
        function(e) {
            e.preventDefault();
            var container = $(this).closest('[data-role="dynamic-fields5"]');
            new_field_group = container.children().filter('.form-inline:first-child').clone();
            new_field_group.find('input').each(function(){
                $(this).val('');
            });
            container.append(new_field_group);
        }
    );
});



$(function() {
    // Remove button click
    $(document).on(
        'click',
        '[data-role="dynamic-fields6"] > .form-inline [data-role="remove"]',
        function(e) {
            e.preventDefault();
            $(this).closest('.form-inline').remove();
        }
    );
    // Add button click
    $(document).on(
        'click',
        '[data-role="dynamic-fields6"] > .form-inline [data-role="add"]',
        function(e) {
            e.preventDefault();
            var container = $(this).closest('[data-role="dynamic-fields6"]');
            new_field_group = container.children().filter('.form-inline:first-child').clone();
            new_field_group.find('input').each(function(){
                $(this).val('');
            });
            container.append(new_field_group);
        }
    );
});


// JavaScript Document