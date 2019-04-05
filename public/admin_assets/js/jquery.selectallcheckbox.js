/*
 * SelectAllCheckbox v3.0
 * https://www.github.com/kloverde/jquery-SelectAllCheckbox
 *
 * Donations:  https://paypal.me/KurtisLoVerde/5
 *
 * Copyright (c) 2016, Kurtis LoVerde
 * All rights reserved.
 *
 * Redistribution and use in source and binary forms, with or without
 * modification, are permitted provided that the following conditions are met:
 *
 *    1. Redistributions of source code must retain the above copyright
 *       notice, this list of conditions and the following disclaimer.
 *    2. Redistributions in binary form must reproduce the above copyright
 *       notice, this list of conditions and the following disclaimer in the
 *       documentation and/or other materials provided with the distribution.
 *    3. Neither the name of the copyright holder nor the names of its
 *       contributors may be used to endorse or promote products derived from
 *       this software without specific prior written permission.
 *
 * THIS SOFTWARE IS PROVIDED BY THE COPYRIGHT HOLDERS AND CONTRIBUTORS "AS IS" AND
 * ANY EXPRESS OR IMPLIED WARRANTIES, INCLUDING, BUT NOT LIMITED TO, THE IMPLIED
 * WARRANTIES OF MERCHANTABILITY AND FITNESS FOR A PARTICULAR PURPOSE ARE
 * DISCLAIMED. IN NO EVENT SHALL THE COPYRIGHT HOLDER OR CONTRIBUTORS BE LIABLE
 * FOR ANY DIRECT, INDIRECT, INCIDENTAL, SPECIAL, EXEMPLARY, OR CONSEQUENTIAL
 * DAMAGES (INCLUDING, BUT NOT LIMITED TO, PROCUREMENT OF SUBSTITUTE GOODS OR
 * SERVICES; LOSS OF USE, DATA, OR PROFITS; OR BUSINESS INTERRUPTION) HOWEVER
 * CAUSED AND ON ANY THEORY OF LIABILITY, WHETHER IN CONTRACT, STRICT LIABILITY,
 * OR TORT (INCLUDING NEGLIGENCE OR OTHERWISE) ARISING IN ANY WAY OUT OF THE USE
 * OF THIS SOFTWARE, EVEN IF ADVISED OF THE POSSIBILITY OF SUCH DAMAGE.
 */

(function( $ ) {
   "use strict";

   $.fn.selectAllCheckbox = function( options ) {

      var settings = $.extend( {
         // The HTML "name" attribute of the checkbox group
         checkboxesName : "checkboxes",

         // A user-defined function to execute when a checkbox in the group changes state.
         // The function must accept two arguments:  the first is an array of the changed
         // checkboxes as jQuery objects.  The second argument is a string representing
         // the checked state of the checkbox group:  possible values are "none", "some"
         // and "all".
         onChangeCallback : undefined,

         // Controls whether the select-all checkbox displays as partially checked when a
         // subset of checkboxes are checked
         useIndeterminate : true
      }, options );

      var GROUP_STATE_NONE = "none",
          GROUP_STATE_SOME = "some",
          GROUP_STATE_ALL  = "all";

      var CHECKBOX_GROUP_SELECTOR = "input[type='checkbox'][name='" + settings.checkboxesName + "']";

      var selectAll = this;

      setSelectAllCheckboxInitialState();

      // The select-all event listener uses 'click' instead of 'change' as a workaround to
      // a known IE issue, where indeterminate checkboxes don't fire the 'change' event.

      selectAll.click( function() {
         var allCheckboxes = $( CHECKBOX_GROUP_SELECTOR );
         var enabledCheckboxes = allCheckboxes.filter( ":enabled" );
         var eligibleForChecking = enabledCheckboxes.filter( ":not(:checked)" );

         var newCheckedProp = eligibleForChecking.length > 0;
         var changedBoxes = [];  // Passed to the callback

         enabledCheckboxes.each( function() {
            var jqThis = $( this );

            if( jqThis.prop("checked") !== newCheckedProp ) {
               jqThis.prop( "checked", newCheckedProp );
               changedBoxes.push( jqThis );
            }
         } );

         var howManyChecked = 0;

         allCheckboxes.each( function() {
            if( $(this).is(":checked") ) {
               howManyChecked++;
            }
         } );

         if( howManyChecked === 0 ) {
            status = GROUP_STATE_NONE;
         } else if( howManyChecked < allCheckboxes.length ) {
            status = GROUP_STATE_SOME;
         } else if( howManyChecked === allCheckboxes.length ) {
            status = GROUP_STATE_ALL;
         } else {
            throw "Impossible result:  more checkboxes checked than actually exist";
         }

         updateSelectAllCheckboxState( status );

         if( changedBoxes.length > 0 && typeof settings.onChangeCallback === "function" ) {
            settings.onChangeCallback( changedBoxes, status );
         }
      } );

      $( CHECKBOX_GROUP_SELECTOR ).each( function() {
         var box = $( this );

         // Updates the select-all checkbox's state and invokes the user-supplied callback.  If you set a checkbox's state
         // via script, you must trigger change() on the modified checkbox to ensure the select-all checkbox's state is
         // updated.  JQuery does not fire change() for you.  The select-all checkbox is different:  it responds to the
         // click event instead of the change event because IE doesn't fire the change event for indeterminate checkboxes.

         box.change( function() {
            var someChecked = false,
                someNotChecked = false;

            var status = GROUP_STATE_NONE;

            $( CHECKBOX_GROUP_SELECTOR ).each( function() {
               if( $(this).prop("checked") === true ) {
                  someChecked = true;
               } else {
                  someNotChecked = true;
               }
            } );

            if( someChecked && someNotChecked ) {
               status = GROUP_STATE_SOME;
            } else if( someChecked && !someNotChecked ) {
               status = GROUP_STATE_ALL;
            } else if( !someChecked ) {
               status = GROUP_STATE_NONE;
            }

            updateSelectAllCheckboxState( status );

            if( typeof settings.onChangeCallback === "function" ) {
               var changedBoxes = [ box ];
               settings.onChangeCallback( changedBoxes, status );
            }
         } );
      } );

      function setSelectAllCheckboxInitialState() {
         var checkboxes = $( CHECKBOX_GROUP_SELECTOR );
         var checkedCount = 0;
         var state = null;

         checkboxes.each( function() {
            var jqThis = $( this );

            if( jqThis.prop("checked") === true ) {
               checkedCount++;
            };

            if( checkedCount === 0 ) {
               state = GROUP_STATE_NONE;
            } else if( checkedCount < checkboxes.length ) {
               state = GROUP_STATE_SOME;
            } else if( checkedCount === checkboxes.length ) {
               state = GROUP_STATE_ALL;
            } else {
               throw "Impossible result:  more checkboxes checked than actually exist";
            }

            updateSelectAllCheckboxState( state );
         } );
      }

      // Sets the select-all checkbox to checked, unchecked or partially checked
      function updateSelectAllCheckboxState( status ) {
         if( status === "some" ) {
            selectAll.prop( "checked", false );

            if( settings.useIndeterminate ) {
               selectAll.prop( "indeterminate", true );
            }
         } else if( status === "all" ) {
            selectAll.prop( "indeterminate", false );
            selectAll.prop( "checked", true );
         } else if( status === "none" ) {
            selectAll.prop( "indeterminate", false );
            selectAll.prop( "checked", false );
         }
      }

      return selectAll;
   };
}( jQuery ));
