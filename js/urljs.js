var bkgrd;
var txtcol;
jQuery(document).ready(function() {
        var getUrlParameter = function getUrlParameter(sParam) {
            var sPageURL = decodeURIComponent(window.location.search),
                sURLVariables = sPageURL.split('&'),
                sParameterName,
                i;

            for (i = 0; i < sURLVariables.length; i++) {
                sParameterName = sURLVariables[i].split('=');
                if (sParameterName[0] === sParam) {
                    return sParameterName[1] === undefined ? true : sParameterName[1];
                }
            }
        }
        var hwrd = getUrlParameter('hword');
        bkgrd = getUrlParameter('bkgrd');
        txtcol = getUrlParameter('txtcol');

        var options = {
            "element": "mark",
            "className": "mrkwrd",
            "exclude": [],
            "separateWordSearch": true,
            "accuracy": "partially",
            "diacritics": true,
            "synonyms": {},
            "iframes": false,
            "acrossElements": false,
            "caseSensitive": false,
            "ignoreJoiners": false,
            "each": function(node) {
                // node is the marked DOM element
            },
            "filter": function(textNode, foundTerm, totalCounter, counter) {
                // textNode is the text node which contains the found term
                // foundTerm is the found search term
                // totalCounter is a counter indicating the total number of all marks
                //              at the time of the function call
                // counter is a counter indicating the number of marks for the found term
                return true; // must return either true or false
            },
            "noMatch": function(term) {
                // term is the not found term
            },
            "done": function(counter) {
                // counter is a counter indicating the total number of all marks
            },
            "debug": false,
            "log": window.console
        };

        if (!(typeof hwrd === 'undefined' || !hwrd)) {
            var context = document.querySelector("div.entry-content");
            var instance = new Mark(context);
            instance.mark(hwrd, options);
            var y = document.getElementsByClassName("mrkwrd");

            for (var ixx = 0; ixx < y.length; ixx++) {
                y[ixx].style.background = "#" + bkgrd;
                y[ixx].style.color = "#" + txtcol;

            }

        }
    }

);