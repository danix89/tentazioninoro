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

class MemoryManagerSingleton {
    constructor() {
        this.memoryManagerInstance = new MemoryManager();
    }

    static getInstance() {
        if (!this.memoryManagerInstance) {
            this.memoryManagerInstance = new MemoryManager();
        }
        return this.memoryManagerInstance;
    }
}

class MemoryManager {
    constructor() {}

    checkIfLocalStorageIsAvailable() {
        if (typeof (Storage) !== undefined) {
            return true;
        } else {
            console.error('The Web Storage APIs are not fully supported in this browser.');
            return false;
        }
    }

    fetchData(name) {
        var value = "";

        if (this.checkIfLocalStorageIsAvailable()) {
            if (localStorage[name] === undefined) {
                if (getDebuggingModeValues().verbose) {
                    console.log(name + " not found. Creating new one:\n");
                }

                localStorage[name] = value;
            } else {
                if (getDebuggingModeValues().verbose) {
                    console.log(name + " found. Fetching from local storage:\n");
                }

                if (localStorage[name] !== "" && isJson(localStorage[name])) {
                    value = JSON.parse(localStorage[name]);
                }
            }
        }

        if (getDebuggingModeValues().verbose) {
            console.log(name + ":");
            console.log(value);
        }

        return value;
    }

    fetchArray(name) {
        var array = mm.fetchData(name);
        if (array === undefined || array === "") {
            array = [];
        }

        return array;
    }

    saveData(name, value) {
        if (this.checkIfLocalStorageIsAvailable()) {

            if (getDebuggingModeValues().verbose) {
                console.log(name + ":");
                console.log(value);
            }

            localStorage[name] = JSON.stringify(value);
        } else {
            return null;
        }
    }

    saveArray(name, array) {
        if (array === undefined || array === "") {
            array = [];
        }
        this.saveData(name, array);
    }

    saveValueToArray(name, value) {
        var array = this.fetchData(name);
        if (array === undefined || array === "") {
            array = [];
        }
        array.push(value);
        
        this.saveData(name, array);
    }

    removeElementFromArray(name, element) {
        var array = this.fetchArray(name);
        
        var index = array.indexOf(element);
        console.log(array);
        if (index > -1) {
            array.splice(index, 1);
        }
        console.log(array);
        this.saveArray(name, array);
        return array;
    }

    resetData(name) {
        localStorage[name] = "";
    }

    resetAll(toReset) {
        var thisObj = this;
        $.each(toReset, function (i) {
            var name = toReset[i];
            console.log(name);
            thisObj.resetData(name);
        });
    }
}

var mm = MemoryManagerSingleton.getInstance();
window.mm = mm;