const { createApp } = Vue

app = createApp({

    data() {
        return {











            
            PanelLanguage: null,
            machinsLoaded: false,
            userHasNoorder: false,

            orders: [],
            user: {},
            WhmcsCurrencies: null,
            invoice: null,
            ConstantInvoiceId: null,

            userCreditinWhmcs: null,
            userCurrencyIdFromWhmcs: null,
            ConstUserId: null,

            chargeAmountinWhmcs: null,
            ConstChargeamountInWhmcs: null,
            chargeAmountAdminInput: null,
            AdminTransSuccess: null,
            adminTransId: null,
            AdminClickOnTrans: null,

            theChargingSteps: 0,
            theStepStatus: 0,

            TransactionError: null,
            GlobalError: null,































            // new
            
            CaasifyConfigs: [],
            systemUrl: null,
            UserOrders: null,
            CaasifyUserInfo: null,
            WhmcsUserInfo: null,
        }
    },

    watch: {
        systemUrl(newsystemUrl) {
            if (newsystemUrl != '') {
                // new
                this.LoadUserOrders();
                this.readLanguageFirstTime();
                this.LoadCaasifyUser();
                this.LoadWhmcsUser();
                this.LoadWhmcsCurrencies();
            }
        }
    },

    mounted() {
        // Old
        this.loadPolling()





        // new
        this.fetchModuleConfig();
    },

    computed: {
        // old
        config() {
            return {
                minimumChargeInCaasifyCurrency: 2,
                DefaultMonthlyDecimal: 0,
                DefaultHourlyDecimal: 2,
                DefaultBalanceDecimalWhmcs: 0,
                DefaultBalanceDecimalCloud: 2,
                DefaultChargeAmountDecimalWhmcs: 0,
                DefaultChargeAmountDecimalCloud: 2,
                DefaultCreditDecimalWhmcs: 0,
                DefaultCreditDecimalCloud: 2,
                DefaultMinimumDecimalWhmcs: 0,
                DefaultMinimumDecimalCloud: 2,
                DefaultRatioDecimal: 0,
            }
        },

        userCurrencySymbolFromWhmcs() {
            if (this.WhmcsCurrencies != null && this.userCurrencyIdFromWhmcs != null) {
                let CurrencyArr = this.WhmcsCurrencies.currency
                let id = this.userCurrencyIdFromWhmcs
                let UserCurrency = null

                CurrencyArr.forEach((item) => {
                    if (item.id == id) {
                        UserCurrency = item.suffix;
                    }
                });

                if (UserCurrency) {
                    return UserCurrency
                } else {
                    return null
                }
            } else {
                return null
            }
        },

        balance() {
            if (this.user.balance) {
                return this.user.balance
            } else {
                return null
            }
        },

        activeorders() {
            let listOforders = []
            if (this.isNotEmpty(this.orders)) {

                listOforders = _.filter(this.orders, order => this.isActive(order.status))

            }
            return listOforders
        },

        chargeAmountInCaasifyCurrency() {
            if (this.chargeAmountinWhmcs != null && this.CurrenciesRatioWhmcsToCloud != null) {
                let value = this.ConverFromWhmcsToCloud(this.chargeAmountinWhmcs)
                return value
            } else {
                return null
            }
        },

        UserCreditInCaasifyCurrency() {
            if (this.userCreditinWhmcs != null && this.CurrenciesRatioWhmcsToCloud != null) {
                let value = this.ConverFromWhmcsToCloud(this.userCreditinWhmcs)
                return value
            } else {
                return null
            }
        },

        chargingValidity() {
            if (this.CurrenciesRatioWhmcsToCloud != null) {
                let usercredit = this.UserCreditInCaasifyCurrency;
                let chargeAmount = this.chargeAmountInCaasifyCurrency;
                let minimum = this.config.minimumChargeInCaasifyCurrency;

                if (usercredit == null || chargeAmount == null) {
                    return null
                } else {
                    if (usercredit == 0) {
                        return "nocredit"
                    } else if (usercredit < minimum) {
                        return "noenoughcredit"
                    } else if (chargeAmount < minimum) {
                        return "noenoughchargeamount"
                    } else if (!this.isIntOrFloat(chargeAmount)) {
                        return "notinteger"
                    } else if (chargeAmount > usercredit) {
                        return "overcredit"
                    } else {
                        return "fine"
                    }
                }
            } else {
                return null
            }
        },

        chargeAmountAdminInputisvalide() {
            let value = this.chargeAmountAdminInput;
            if (value != null && this.isIntOrFloat(value)) {
                return true
            } else {
                return false
            }
        },

        CurrenciesRatioCloudToWhmcs() {
            if (this.userCurrencyIdFromWhmcs != null && this.CaasifyDefaultCurrencyID != null) {
                let userCurrencyId = this.userCurrencyIdFromWhmcs;
                let CaasifyCurrencyID = this.CaasifyDefaultCurrencyID;

                if (userCurrencyId == CaasifyCurrencyID) {
                    return 1
                } else {
                    let userCurrencyRatio = this.findRationFromId(userCurrencyId)
                    let CaasifyCurrencyRatio = this.findRationFromId(CaasifyCurrencyID)

                    if (userCurrencyRatio != null && CaasifyCurrencyRatio != null) {
                        return userCurrencyRatio / CaasifyCurrencyRatio;
                    } else {
                        return null
                    }
                }
            } else {
                return null
            }
        },

        CurrenciesRatioWhmcsToCloud() {
            if (this.CurrenciesRatioCloudToWhmcs != null) {
                return 1 / this.CurrenciesRatioCloudToWhmcs
            } else {
                return null
            }
        },
        // end old










        //   new
        CaasifyDefaultCurrencySymbol() {
            if (this.CaasifyConfigs?.CaasifyCurrency != null) {
                return this.CaasifyConfigs.CaasifyCurrency
            } else {
                return null
            }
        },

        CaasifyDefaultCurrencyID() {
            let CaasifyDefaultCurrencyID = null
            if (this.WhmcsCurrencies != null && this.CaasifyConfigs != null) {
                let CaasifyCurrency = this.CaasifyConfigs?.CaasifyCurrency;
                let WhmcsCurrencies = this.WhmcsCurrencies;

                if (CaasifyCurrency != null && WhmcsCurrencies.currency != null) {
                    WhmcsCurrencies?.currency.forEach((item, index) => {
                        if (item.code == CaasifyCurrency) {
                            CaasifyDefaultCurrencyID = item.id
                        }
                    })
                } else {
                    console.error('finfing caasify currency ID failed');
                }
            }
            return CaasifyDefaultCurrencyID
        },


    },

    methods: {
        // old
        isIntOrFloat(value) {
            if (typeof value === 'number' && !Number.isNaN(value)) {
                return true
            } else {
                return false
            }
        },

        ConverFromWhmcsToCloud(value) {
            if (this.CurrenciesRatioWhmcsToCloud) {
                let ratio = this.CurrenciesRatioWhmcsToCloud
                return value * ratio
            } else {
                return null
            }
        },

        ConverFromCaasifyToWhmcs(value) {
            if (this.CurrenciesRatioCloudToWhmcs) {
                let ratio = this.CurrenciesRatioCloudToWhmcs
                return value * ratio
            } else {
                return null
            }
        },

        formatNumbers(number, decimal) {
            const formatter = new Intl.NumberFormat('en-US', {
                style: 'decimal',
                minimumFractionDigits: decimal,
                maximumFractionDigits: decimal,
            });
            return formatter.format(number);
        },

        showBalanceWhmcsUnit(value) {
            decimal = this.config.DefaultBalanceDecimalWhmcs
            return this.formatNumbers(value, decimal)
        },

        showBalanceCloudUnit(value) {
            decimal = this.config.DefaultBalanceDecimalCloud
            return this.formatNumbers(value, decimal)
        },

        showChargeAmountWhmcsUnit(value) {
            decimal = this.config.DefaultChargeAmountDecimalWhmcs
            return this.formatNumbers(value, decimal)
        },

        showChargeAmountCloudUnit(value) {
            decimal = this.config.DefaultChargeAmountDecimalCloud
            return this.formatNumbers(value, decimal)
        },

        showCreditWhmcsUnit(value) {
            decimal = this.config.DefaultCreditDecimalWhmcs
            return this.formatNumbers(value, decimal)
        },

        showCreditCloudUnit(value) {
            decimal = this.config.DefaultCreditDecimalCloud
            return this.formatNumbers(value, decimal)
        },

        showRatio(value) {
            decimal = this.config.DefaultRatioDecimal
            return this.formatNumbers(value, decimal)
        },

        showMinimumeWhmcsUnit(value) {
            decimal = this.config.DefaultMinimumDecimalWhmcs
            return this.formatNumbers(value, decimal)
        },

        showMinimumeCloudUnit(value) {
            decimal = this.config.DefaultMinimumDecimalWhmcs
            return this.formatNumbers(value, decimal)
        },


        findRationFromId(id) {
            if (this.WhmcsCurrencies != null) {
                let CurrencyArr = this.WhmcsCurrencies.currency

                let rate = null
                CurrencyArr.forEach((item) => {
                    if (item.id == id) {
                        rate = item.rate;
                    }
                });
                // console.error(rate);

                if (rate) {
                    return rate
                } else {
                    return null
                }
            } else {
                return null
            }
        },

        formatBalance(balance, decimal = 2) {

            return Number(balance).toFixed(decimal)
        },

        formatCost(value, decimal = 2) {

            return Number(value).toFixed(decimal)
        },

        SuccessWindow() {
            const successModal = document.getElementById('successModal');
            const chargeModal = document.getElementById('chargeModal');

            $("#chargeModal").modal('hide');
            $("#successModal").modal('show');
        },

        FailWindow() {
            const failModal = document.getElementById('failModal');
            const chargeModal = document.getElementById('chargeModal');

            $("#chargeModal").modal('hide');
            $("#failModal").modal('show');
        },

        reloadpage() {
            location.reload()
        },

        loadPolling() {

            // Load order
            setInterval(this.loadorder, 30000)

            // Load User
            setInterval(this.loadUser, 30000)

            // Load Credit
            setInterval(this.loadCredit, 15000)

            // Load Currencies
            setInterval(this.loadWhCurrencies, 50000)

        },

        isEmpty(value) {

            if (_.isEmpty(value)) {
                return true
            } else {
                return false
            }
        },

        isNotEmpty(value) {

            if (_.isEmpty(value)) {
                return false
            } else {
                return true
            }
        },

        getProperty(data, name, empty = null) {

            let value = _.get(data, name)

            if (value) {
                return value
            } else {
                return empty
            }
        },

        isOnline(status) {

            if (status == 'online') {
                return true
            } else {
                return false
            }
        },

        isOffline(status) {

            if (status == 'offline') {
                return true
            } else {
                return false
            }
        },

        isActive(status) {

            if (status == 'active') {
                return true
            } else {
                return false
            }
        },

        isPassive(status) {

            if (status == 'offline') {
                return true
            } else {
                return false
            }
        },

        open(order) {
            let address = '/modules/addons/cloudsnp/views/Caasify/order.php?m=cloudsnp'
            let params = new URLSearchParams({
                'action': 'pageorder', 'id': order.id
            }).toString()
            window.open([address, params].join('&'), "_top")
        },

        opencreatepage() {

            let address = '/modules/addons/cloudsnp/views/Caasify/create.php'

            window.open([address], "_top")

        },

        address(order) {

            let listOfReserves = []

            if (this.isNotEmpty(order)) {

                listOfReserves = _.filter(order.reserves, reserve => this.isActive(reserve.status))
            }

            let listOfIPs = []

            _.forEach(listOfReserves, function (reserve) {

                listOfIPs.push(reserve.address.address)
            })

            return listOfIPs.shift()
        },

        online(order) {

            let status = this.getProperty(order, 'powerStatus.value')

            if (this.isOnline(status)) {
                return true
            } else {
                return false
            }
        },

        offline(order) {

            let status = this.getProperty(order, 'powerStatus.value')

            if (this.isOffline(status)) {
                return true
            } else {
                return false
            }
        },





    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
        // old load
        async CreateUnpaidInvoice() {
            this.ConstChargeamountInWhmcs = Object.freeze({value: this.chargeAmountinWhmcs});            
            const chargeAmountinWhmcs = this.ConstChargeamountInWhmcs.value 
            let chargingValidity = this.chargingValidity;
            this.theChargingSteps = 1;
            this.theStepStatus = 11;
            
            const params = {chargeamount: chargeAmountinWhmcs};

            if(chargingValidity == 'fine'){
                RequestLink = this.CreateRequestLink(action = 'CreateUnpaidInvoice');
                let response = await axios.post(RequestLink, params);            
                if(response?.data.result == 'success'){    
                    this.invoice = response?.data;
                    this.ConstantInvoiceId = Object.freeze({value: response?.data.invoiceid});
                    setTimeout(() => {
                        this.theStepStatus = 12;
                        this.chargeCaasify();
                    }, 6000);
                } else {
                    this.GlobalError = 1
                    setTimeout(() => {
                        this.theStepStatus = 13;
                        this.TransactionError = 'error 1',
                        setTimeout(() => {
                            this.FailWindow();
                        }, 3000);
                    }, 3000);
                }
            } else {
                return null
            }
        },



        async chargeCaasify() {
            const id = this.ConstUserId.value;
            const chargeamountInAutovm = this.ConverFromWhmcsToCloud(this.ConstChargeamountInWhmcs.value);
            const invoiceid = this.ConstantInvoiceId.value

            this.theChargingSteps = 2;
            this.theStepStatus = 21;

            const params = {
                chargeamount: chargeamountInAutovm,
                id: id,
                invoiceid: invoiceid,

            };

            if(id > 0){
                RequestLink = this.CreateRequestLink(action = 'chargeCaasify');
                let response = await axios.post(RequestLink, params);            
                if(response?.data.data){
                    setTimeout(() => {
                        this.theStepStatus = 22;
                        this.applyTheCredit();
                    }, 6000);
                } else {
                    this.GlobalError = 2
                    this.markCancelInvoice()
                    setTimeout(() => {
                        this.theStepStatus = 23;
                        this.TransactionError = 'error 2',
                        setTimeout(() => {
                            this.FailWindow();
                        }, 3000);
                    }, 3000);
                }
            } else {
                return null
            }
        },

        async markCancelInvoice() {
            const invoiceid = this.ConstantInvoiceId.value;
            const params = {invoiceid: invoiceid};
            RequestLink = this.CreateRequestLink(action = 'markCancelInvoice');
            let response = await axios.post(RequestLink, params);            
            if(response?.data.result == 'success'){    
                console.log('Invoice is marked cancelled successfully');
            } else {
                console.log('can not able to clear invoice'); 
            }
        },
        
        async applyTheCredit() {
            const invoiceid = this.ConstantInvoiceId.value;
            const chargeamountinWhmcs = this.ConstChargeamountInWhmcs.value
            
            this.theChargingSteps = 3;
            this.theStepStatus = 31;

            const params = {invoiceid: invoiceid, chargeamount : chargeamountinWhmcs};

            if(invoiceid > 0){
                RequestLink = this.CreateRequestLink(action = 'applyTheCredit');
                let response = await axios.post(RequestLink, params);            
                
                if(response?.data.result == 'success'){
                    setTimeout(() => {
                        this.theStepStatus = 32;
                        setTimeout(() => {
                            this.SuccessWindow();
                        }, 1500);
                    }, 6000);
                } else {
                    this.GlobalError = 3
                    setTimeout(() => {
                        this.theStepStatus = 33;
                        this.TransactionError = 'error 3',
                        setTimeout(() => {
                            this.FailWindow();
                        }, 3000);
                    }, 3000);
                }
            } else {
                return null
            }
        },














































        // new
        fetchModuleConfig() {
            fetch('configApi.php')  // Use a relative path to reference the PHP file
                .then(response => response.json())
                .then(data => {
                    this.CaasifyConfigs = data.configs;
                    this.systemUrl = data.configs.systemUrl;
                    if (this.systemUrl == '') {
                        console.error('systemUrl is empty');
                    }
                })
                .catch(error => {
                    console.error('Error fetching root directory address:');
                });
        },

        readLanguageFirstTime() {
            this.PanelLanguage = this.getCookieValue('temlangcookie');
        },

        changeLanguage() {
            let newLang = this.PanelLanguage;
            document.cookie = `temlangcookie=${newLang}; expires=${new Date(Date.now() + 365 * 86400000).toUTCString()}; path=/`;
            window.location.reload();
        },

        getCookieValue(cookieName) {
            const name = cookieName + "=";
            const decodedCookie = decodeURIComponent(document.cookie);
            const cookieArray = decodedCookie.split(';');

            for (let i = 0; i < cookieArray.length; i++) {
                let cookie = cookieArray[i];
                while (cookie.charAt(0) === ' ') {
                    cookie = cookie.substring(1);
                }
                if (cookie.indexOf(name) === 0) {
                    return cookie.substring(name.length, cookie.length);
                }
            }
            return null; // Return an empty string if the cookie is not found
        },

        lang(name) {
            let output = name
            _.forEach(words, function (first, second) {
                if (second.toLowerCase() == name.toLowerCase()) {
                    output = first
                }
            })
            return output
        },

        CreateRequestLink(action) {
            let systemUrl = this.systemUrl;
            let RequestLink = systemUrl + '/index.php?m=caasify&action=' + action;
            return RequestLink;
        },

        async LoadUserOrders() {
            RequestLink = this.CreateRequestLink(action = 'UserOrders');
            let response = await axios.get(RequestLink);

            if (response.data?.data != null) {
                this.UserOrders = response.data.data

                this.orders = response?.data
                this.machinsLoaded = true

            } else if (response.data?.message) {
                this.machinsLoaded = true
                if (response?.data.message == "There is nothing.") {
                    this.userHasNoorder = true;
                } else {
                    console.error('UserOrders: ' + response.data.message);
                }
            }
        },

        async LoadCaasifyUser() {
            RequestLink = this.CreateRequestLink(action = 'CaasifyUserInfo');
            let response = await axios.get(RequestLink);
            if (response?.data?.data) {
                this.CaasifyUserInfo = response.data.data

                this.user = response?.data.data
                this.ConstUserId = Object.freeze({ value: response?.data?.data.id });
            } else if (response?.data?.message) {
                console.error('CaasifyUserInfo: ' + response.data.message);
            }
        },

        async LoadWhmcsUser() {
            RequestLink = this.CreateRequestLink(action = 'WhmcsUserInfo');
            let response = await axios.get(RequestLink);
            if (response?.data) {
                this.WhmcsUserInfo = response.data

                this.userCreditinWhmcs = response?.data.credit;
                this.userCurrencyIdFromWhmcs = response?.data.userCurrencyId;
            } else {
                console.error('WhmcsUserInfo: ' + 'no response');
            }
        },

        async LoadWhmcsCurrencies() {
            RequestLink = this.CreateRequestLink(action = 'WhmcsCurrencies');
            let response = await axios.get(RequestLink);
            if (response?.data) {
                this.WhmcsCurrencies = response.data.currencies
            } else {
                console.error('WhmcsCurrencies: ' + 'no response');
            }
        },

    }
});

app.config.compilerOptions.isCustomElement = tag => tag === 'btn'
app.mount('#indexapp') 