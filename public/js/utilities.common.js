/* 
 * The MIT License
 *
 * Copyright 2017 Daniele Iannone <daniele.iannone@datonix.it>.
 *
 * Permission is hereby granted, free of charge, to any person obtaining a copy
 * of this software and associated documentation files (the "Software"), to deal
 * in the Software without restriction, including without limitation the rights
 * to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
 * copies of the Software, and to permit persons to whom the Software is
 * furnished to do so, subject to the following conditions:
 *
 * The above copyright notice and this permission notice shall be included in
 * all copies or substantial portions of the Software.
 *
 * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
 * IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
 * FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
 * AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
 * LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
 * OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN
 * THE SOFTWARE.
 */

var debuggingModeValues = {};

function $_GET(param) {
    var vars = {};
    window.location.href.replace(location.hash, "").replace(
            /[?&]+([^=&]+)=?([^&]*)?/gi, // regexp
            function (m, key, value) { // callback
                vars[key] = value !== undefined ? value : '';
            }
    );

    if (param) {
        return vars[param] ? vars[param] : null;
    }
    return vars;
}
window.$_GET = $_GET;

function getDebuggingModeValues(verbose = false) {
    if (debuggingModeValues.debuggingMode === undefined || debuggingModeValues.verbose === undefined) {
//        console.warn(debuggingModeValues);
        debuggingModeValues = {};
        debuggingModeValues.debuggingMode = false;
        debuggingModeValues.verbose = false;
        var debuggingMode = $_GET('debuggingMode');

        if (debuggingMode > 0) {
            var debuggingModeMessage = "[ATTENTION]: Debugging mode activated!!!";
            if (debuggingMode == 1) {
                debuggingModeValues.verbose = true;
                if (verbose) {
                    console.warn("Verbose on.");
                }
            } else if (debuggingMode == 2) {
                debuggingModeValues.debuggingMode = true;
                if (verbose) {
                    console.warn(debuggingModeMessage);
                    console.warn("Verbose off.");
                }
            } else if (debuggingMode == 3) {
                debuggingModeValues.debuggingMode = true;
                debuggingModeValues.verbose = true;
                if (verbose) {
                    console.warn(debuggingModeMessage);
                    console.warn("Verbose on.");
                }
            }
        }
    }

    return debuggingModeValues;
}
window.getDebuggingModeValues = getDebuggingModeValues;

function reloadPage(timeout) {
    console.log("Refreshing della pagina...");
    console.log("Se questo messaggio rimane qualcosa è andato storto!!!");

    setTimeout(function () {
        window.location = window.location;
        console.log("Refresh della pagina completato.");
    }, timeout);
}

function checkIfAdblockIsActive() {
    if (window.canRunAds === undefined) {
        alert("Disattiva Adblock per utilizzare il plugin correttamente.");
        document.getElementById("wpbody").innerHTML = "";
    }
}
window.checkIfAdblockIsActive = checkIfAdblockIsActive;

function isJson(str, verbose = false) {
    try {
        JSON.parse(str);
    } catch (e) {
        if(getDebuggingModeValues().verbose) {
            console.warn("str is not a valid json string!");
            console.warn(str);
        }
        
        if(verbose) {
            console.warn(e);
        }
        
        return false;
    }
    return true;
}