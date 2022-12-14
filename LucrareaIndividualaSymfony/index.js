var app = angular.module("myApp", []);
app.directive('validateEmail', function () {
    var EMAIL_REGEXP = /^[_a-z0-9]+(\.[_a-z0-9]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,4})$/;
    return {
        link: function (scope, elm) {
            elm.on("keyup", function () {
                var isMatchRegex = EMAIL_REGEXP.test(elm.val());
                if (isMatchRegex && elm.hasClass('warning') || elm.val() === '') {
                    elm.removeClass('warning');
                } else if (isMatchRegex === false && !elm.hasClass('warning')) {
                    elm.addClass('warning');
                }
            });
        }
    }
});

app.directive('validatePassword', function () {
    var PASS_REGEXP = /(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{5,}/;
    return {
        link: function (scope, elm) {
            elm.on("keyup", function () {
                var isMatchRegex = PASS_REGEXP.test(elm.val());
                if (isMatchRegex && elm.hasClass('warning') || elm.val() === '') {
                    elm.removeClass('warning');
                } else if (isMatchRegex === false && !elm.hasClass('warning')) {
                    elm.addClass('warning');
                }
            });
        }
    }
});


app.service('register', function () {
    this.inregistreaza = function (lista, emaill, passwordd) {
        var newUser = {email: emaill, pass: passwordd}
        var gasit = false
        if (!lista) {
            return newUser
        }
        lista.forEach((item, index) => {
            if (item.email === newUser.email) {
                gasit = true
            }
        });
        if (!gasit) {
            return newUser
        } else {
            return null
        }
    }

});

app.service('login', function () {
    this.logare = function (lista, email, pass) {
        return "";
    }
});

app.service('localData', function () {
    this.getEsteLogat = function () {
        return window.localStorage.getItem('esteLogat');
    }
    this.getUtilizatorCurrent = function () {
        return window.localStorage.getItem('utilizatorulCurrent');
    }
    this.getRegistered = function () {
        var reg = localStorage.getItem("getRegistered");
        if (!reg) {
            return null
        } else {
            return JSON.parse(reg);
        }
    }

    this.setEsteLogat = function (x) {
        window.localStorage.setItem('esteLogat', x);
    }

    this.setUtilizatorCurrent = function (x) {
        if (!x) {
            window.localStorage.removeItem('utilizatorulCurrent');
        } else {
            window.localStorage.setItem('utilizatorulCurrent', x);
        }
    }

    this.addNewRegisteredUser = function (x) {
        var currentUsers = this.getRegistered();
        if (!currentUsers) {
            currentUsers = new Array()
        }
        currentUsers.push(x);
        window.localStorage.setItem('getRegistered', JSON.stringify(currentUsers));

    }
});

app.service('rutare', function () {
    this.goToPage = function (x) {
        window.location.href = x;
        // window.location.replace("login.html");
    }
});


app.directive('modal', function () {
    return {
        template: '<div class="modal fade">' +
            '<div class="modal-dialog">' +
            '<div class="modal-content">' +
            '<div class="modal-header">' +
            '<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>' +
            '<h4 class="modal-title">{{ title }}</h4>' +
            '</div>' +
            '<div class="modal-body" ng-transclude></div>' +
            '</div>' +
            '</div>' +
            '</div>',
        restrict: 'E',
        transclude: true,
        replace: true,
        scope: true,
        link: function postLink(scope, element, attrs) {
            scope.title = attrs.title;

            scope.$watch(attrs.visible, function (value) {
                if (value == true)
                    $(element).modal('show');
                else
                    $(element).modal('hide');
            });

            $(element).on('shown.bs.modal', function () {
                scope.$apply(function () {
                    scope.$parent[attrs.visible] = true;
                });
            });

            $(element).on('hidden.bs.modal', function () {
                scope.$apply(function () {
                    scope.$parent[attrs.visible] = false;
                });
            });
        }
    };
});


//Serviciu pentru calcule
app.service('calc', function () {
    this.myitems = [];
    this.getValue = function () {
        return this.myitems
    }; //getter

    this.addToCart = function (x) {
        this.myitems.push(x);
        var suma = 0
        this.myitems.forEach((item, index) => {
            suma += item.pretul
        });
        console.log(this.myitems)
        console.log(suma)
        return suma;
        // window.location.replace("login.html");
    }

    this.removeFromCart = function (x) {
        this.myitems.splice(x, 1);
        var suma = 0
        this.myitems.forEach((item, index) => {
            suma += item.pretul
        });
        return suma
    }
});

app.controller("headerCtrl", function ($scope, register, login, localData, rutare, calc) {
    $scope.updateData = function () {
        $scope.esteLogat = localData.getEsteLogat();
        $scope.utilizatorulCurrent = localData.getUtilizatorCurrent();
        $scope.registered = localData.getRegistered()
    }
    $scope.updateData();
    console.log($scope);
    $scope.go = function (page) {
        rutare.goToPage(page);
    }

    $scope.logout = function () {
        localData.setUtilizatorCurrent(null);
        $scope.go('index.html')
    }

    $scope.showModal = false;
    $scope.toggleModal = function () {
        $scope.showModal = !$scope.showModal;
    };

    $scope.submitLogout = function () {
        console.log("submitLogout")
    }

});

app.controller("homeCtrl", function ($scope, register, login, localData, calc) {
    $scope.items = [
        {
            nume: "Apple Macbook Pro",
            imagineURL: "https://www.zap.md/sites/default/files/imagecache/product-large/apple-macbook-pro-16-sg.png",
            pretul: 23.599
        },
        {
            nume: "Asus TUF FX505DT",
            imagineURL: "https://www.zap.md/sites/default/files/imagecache/product_by_category/asus-rog-strix-g15-g512.png",
            pretul: 21.489
        },
        {
            nume: "Acer Swift 3 SF314-57",
            imagineURL: "https://www.zap.md/sites/default/files/imagecache/product_by_category/acer-swift-3-sf314-57-p.png",
            pretul: 14.599
        },
        {
            nume: "Lenovo ThinkBook 15",
            imagineURL: "https://www.zap.md/sites/default/files/imagecache/product_by_category/lenovo-thinkbook-15-iml.png",
            pretul: 16.349
        },
        {
            nume: "HP EliteBook 855 G7",
            imagineURL: "https://www.zap.md/sites/default/files/imagecache/product_by_category/hp-elitebook-855-g7.png",
            pretul: 19.369
        },
        {
            nume: "Dell Inspiron 15 5501",
            imagineURL: "https://www.zap.md/sites/default/files/imagecache/product_by_category/dell-inspiron-15-5501-s.png",
            pretul: 14.649
        },
        {
            nume: "Acer Nitro 5 AN515-54",
            imagineURL: "https://www.zap.md/sites/default/files/imagecache/product_by_category/acer-nitro-5-an515-54.png",
            pretul: 21.499
        },
        {
            nume: "Apple MacBook Air",
            imagineURL: "https://www.zap.md/sites/default/files/imagecache/product_by_category/apple-macbook-air-2020-sg.png",
            pretul: 22.599
        },
        {
            nume: "Apple MacBook Air",
            imagineURL: "https://www.zap.md/sites/default/files/imagecache/product_by_category/apple-macbook-air-2020-s_0.png",
            pretul: 21.499
        },
        {
            nume: "ZenBook ASUS 14",
            imagineURL: "https://www.zap.md/sites/default/files/imagecache/product_by_category/asus-zenbook-14-ux433fac-bl.png",
            pretul: 29.299
        },
        {
            nume: "Dell XPS 15 9575",
            imagineURL: "https://www.zap.md/sites/default/files/imagecache/product_by_category/dell-xps-15-9575.png",
            pretul: 28.599
        },
        {
            nume: "Xiaomi Mi Gaming Laptop",
            imagineURL: "https://www.zap.md/sites/default/files/imagecache/product_by_category/xiaomi-mi-gaming-laptop.png",
            pretul: 32.999
        },
    ]
    $scope.varianteLimitare = [
        "",
        "3",
        "10"
    ]
    $scope.elementeCos = 0
    $scope.suma = 0
    // $scope.itemiAfisare = $scope.items;
    $scope.updateData = function () {
        $scope.esteLogat = localData.getEsteLogat();
        $scope.utilizatorulCurrent = localData.getUtilizatorCurrent();
        $scope.registered = localData.getRegistered()
    }
    $scope.updateData();

    $scope.cardItems = calc.getValue();

    $scope.addToCard = function (x) {
        $scope.elementeCos++;
        $scope.suma = calc.addToCart(x);
        $scope.cardItems = calc.getValue();
    }

    $scope.removeItem = function (x) {
        $scope.errortext = "";
        $scope.elementeCos--;
        $scope.suma = calc.removeFromCart(x);
        $scope.cardItems = calc.getValue();
    }
    $scope.ILoveAngular = "UNIVERSITATEA DE STAT DIN MOLDOVA"

    $scope.executeCopy = function () {
        alert("Numele a fost copiat cu success!")
    }

    $scope.executeOnCut = function () {
        alert("Ați făcut 'cut' la textul din input")
    }

    $scope.executeOnPaste = function () {
        alert("Textul a fost introdus cu success")
    }

    $scope.count = 0;

    $scope.getdetails = function () {

        $scope.count = $scope.count + 1;

    }

});


app.controller("myCtrl", function ($scope, register, login, localData, rutare) {
    $scope.emailError = "";

    $scope.go = function (page) {
        rutare.goToPage(page);
    }

    $scope.updateData = function () {
        $scope.esteLogat = localData.getEsteLogat();
        $scope.utilizatorulCurrent = localData.getUtilizatorCurrent();
        $scope.registered = localData.getRegistered()
    }
    $scope.updateData();
    console.log($scope.registered);
    $scope.verificaDate = function () {
        $scope.loginDezactivat = !$scope.email || !$scope.password
    }

    $scope.verificateDateRegister = function () {
        var tempV = !$scope.email || !$scope.password || !$scope.passwordRepeat
        if (!tempV && $scope.passwordRepeat != $scope.password) {
            tempV = true;
        }
        $scope.registerDezactivat = tempV
    }

    $scope.submitLogin = function () {

        var em = document.getElementById('email')
        var pass = document.getElementById('pwd')
        $scope.showPasswordSecret = true;
        $scope.mesajError = ""
        $scope.mesajSuccess = ""
        if (em.classList.contains('warning')) {
            $scope.mesajError = "Introduce un email valid"

        } else if (pass.classList.contains('warning')) {
            $scope.mesajError = "Introduce o parola ce va conține cel puțin 5 caractere și obligatoriu să includă 1 majusculă, 1 minusculă și 1 cifră"

        } else {
            var gasit = false
            $scope.registered.forEach((item, index) => {
                if (item.email === $scope.email && item.pass === $scope.password) {
                    //schimba in serviciu
                    gasit = true;
                    $scope.mesajSuccess = "Autentificarea a fost efectuată cu success!!";
                    localData.setUtilizatorCurrent(item.email)
                    // Simulate an HTTP redirect:
                    $scope.go('index.html')
                }

                console.log(item)
                //Some code...
            });
            if (!gasit) {
                $scope.mesajError = "Nu a fost găsit acest utilizator!!!"
            }
        }
    }

    $scope.submitRegister = function () {
        var em = document.getElementById('email')
        var pass = document.getElementById('psw')
        var pass2 = document.getElementById('psw2')

        $scope.mesajError = ""
        $scope.mesajSuccess = ""
        if (em.classList.contains('warning')) {
            $scope.mesajError = "Introduce un email valid"
        } else if (pass.classList.contains('warning')) {
            $scope.mesajError = "Introduce o parola ce va conține cel puțin 5 caractere și obligatoriu să includă 1 majusculă, 1 minusculă și 1 cifră"
        } else if (pass2.classList.contains('warning')) {
            $scope.mesajError = "Introduce o parola ce va conține cel puțin 5 caractere și obligatoriu să includă 1 majusculă, 1 minusculă și 1 cifră"
        } else {
            var newUser = register.inregistreaza($scope.registered, $scope.email, $scope.password)
            if (!newUser) {
                $scope.mesajError = "Acest utilizator este deja înregistrat!!!"
            } else {
                localData.addNewRegisteredUser(newUser)
                $scope.updateData();
                console.log($scope.registered);
                $scope.email = "";
                $scope.password = "";
                $scope.passwordRepeat = "";
                $scope.mesajSuccess = "Ați fost înregistrat cu success"
                $scope.go("login.html");
            }
        }
    }

});



