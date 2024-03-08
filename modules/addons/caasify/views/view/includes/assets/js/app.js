const { createApp } = Vue

app = createApp({

    data() {
        return {

            // views
            machineID: null,


            views: null,
            viewsAreLoading: null,
            viewsAreLoaded: null,
            ValidViewItems: null,
            NoValidViewItems: null,

            NewViewStatus: null,

            Controllers: null,
            ValidControllerItems: null,
            ControllersAreLoading: true,
            NoValidControllerItems: null,
            
            
            





            // Generals
            fileName: null,
            PanelLanguage: null,
            WhmcsCurrencies: null,
            userCreditinWhmcs: null,
            userCurrencyIdFromWhmcs: null,
            CaasifyConfigs: [],
            systemUrl: null,
            BackendUrl: null,
            CaasifyUserInfo: null,
            WhmcsUserInfo: null,


            // index
            machinsLoaded: false,

            user: {},
            UserOrders: null,
            userHasNoorder: false,
            ConstUserId: null,


            chargeAmountinWhmcs: null,
            ConstChargeamountInWhmcs: null,
            chargeAmountAdminInput: null,
            invoice: null,
            ConstantInvoiceId: null,

            AdminTransSuccess: null,
            adminTransId: null,
            AdminClickOnTrans: null,
            theChargingSteps: 0,
            theStepStatus: 0,
            TransactionError: null,
            GlobalError: null,


            // Create
            PanelLanguage: null,
            moduleConfig: null,
            moduleConfigIsLoaded: null,


            checkboxconfirmation: null,
            msg: null,
            RullesText: null,


            categories: [],
            DataCenters: [],
            DataCenterName: '',
            DataCenterID: '',
            DataCentersAreLoaded: false,
            DataCentersLength: 0,

            regions: [],
            regionId: null,
            regionName: null,
            regionsAreLoaded: false,
            regionsLength: null,
            regionIsSelected: null,
            regionsAreLoading: null,

            plans: [],
            planId: null,
            planName: null,
            planPrice: null,
            plansAreLoaded: false,
            plansAreLoading: false,
            planIsSelected: false,
            plansLength: 0,

            confirmDialog: false,
            confirmTitle: null,
            confirmText: null,

            messageDialog: false,
            messageText: null,



            themachinename: null,
            MachineNameValidationError: false,
            SshNameValidationError: false,
            MachineNamePreviousValue: "",
            SshNamePreviousValue: "",

            themachinessh: null,

            createActionFailed: false,
            createActionSucced: false,
            userClickedCreationBtn: false,

            
            
            PlanSections: null,
            PlanSectionsLoading: null,
            PlanSectionsLoaded: null,
            
            
            PlanConfigs: null,
            EmptyPlanConfigs: true,
            PlanConfigSelectedOptions: {},
            PlanConfigPrice: {},

            



            


        }
    },

    watch: {

        thisOrder(){
            this.findValidControllers();
        },

        fileName(newFielName) {
            if (newFielName != null) {
                if (newFielName == "index.php") {
                    this.LoadUserOrders();
                    this.readLanguageFirstTime();
                    this.LoadCaasifyUser();
                    this.LoadWhmcsUser();
                    this.LoadWhmcsCurrencies();
                    // this.loadPolling()

                } else if (newFielName == "create.php") {

                    this.LoadCaasifyUser();
                    this.LoadWhmcsUser();
                    this.LoadWhmcsCurrencies();
                    this.loadDataCenters();
                    this.readLanguageFirstTime();

                } else if (newFielName == "view.php") {
                    this.machineId();
                    this.LoadUserOrders();
                    this.readLanguageFirstTime();
                    this.LoadCaasifyUser();
                    this.LoadWhmcsUser();
                    this.LoadWhmcsCurrencies();
                }
            }
        },

        machineID(newmachineID) {
            if (newmachineID != '') {
                this.LoadOrderViews();
                
            }
        },

        systemUrl(newsystemUrl) {
            if (newsystemUrl != '') {
                this.loadUrl();
            }
        },

        regionId() {
            this.loadPlans()
        },

    },

    mounted() {
        this.fetchModuleConfig();
    },

    computed: {

        thisOrder(){ 
            if(this.machineID != null && this.UserOrders != null){
                for (var i = 0; i < this.UserOrders.length; i++) {
                    var order = this.UserOrders[i];
                    if(order.id = this.machineID){
                        return order
                    }
                }
            }
            return false
        },

        planConfigsPrice(){
            
        },

        config() {
            return {
                // index & create
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
            if (this.isNotEmpty(this.UserOrders)) {

                listOforders = _.filter(this.UserOrders, order => this.isActive(order.status))

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

        NewMachinePrice() {
            let NewMachinePrice = 0

            let decimal = this.config.DefaultMonthlyDecimal
            let planPrice = this.planPrice
            let ConfigPrice = this.SumConfigPrice()

            let planPriceFloat = parseFloat(planPrice);
            let ConfigPriceFloat = parseFloat(ConfigPrice);

            if (!isNaN(planPriceFloat) && !isNaN(ConfigPriceFloat)) {
                NewMachinePrice = planPriceFloat + ConfigPriceFloat;
            }

            return NewMachinePrice
        },

        ConfigsAreComplete(){
            let obj = this.PlanConfigSelectedOptions;

            for (let key in obj) {
                if(obj[key] == 'empty'){
                    return false
                }
            }

            return true
        },

    },

    methods: {

        // Commons
        loadUrl() {
            let url = window.location.href;
            let pathname = new URL(url).pathname;
            var parts = pathname.split('/');
            var filename = parts[parts.length - 1];
            this.fileName = filename;
        },

        fetchModuleConfig() {
            fetch('configApi.php')  // Use a relative path to reference the PHP file
                .then(response => response.json())
                .then(data => {
                    this.CaasifyConfigs = data.configs;
                    this.systemUrl = data.configs.systemUrl;
                    this.BackendUrl = data.configs.BackendUrl;
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








        // index
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
            let address = '/index.php?m=caasify'
            let params = new URLSearchParams({
                'action': 'pageView', 'id': order.id
            }).toString()
            window.open([address, params].join('&'), "_top")
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

        async CreateUnpaidInvoice() {
            this.ConstChargeamountInWhmcs = Object.freeze({ value: this.chargeAmountinWhmcs });
            const chargeAmountinWhmcs = this.ConstChargeamountInWhmcs.value
            let chargingValidity = this.chargingValidity;
            this.theChargingSteps = 1;
            this.theStepStatus = 11;

            const params = { chargeamount: chargeAmountinWhmcs };

            if (chargingValidity == 'fine') {
                RequestLink = this.CreateRequestLink(action = 'CreateUnpaidInvoice');
                let response = await axios.post(RequestLink, params);
                if (response?.data.result == 'success') {
                    this.invoice = response?.data;
                    this.ConstantInvoiceId = Object.freeze({ value: response?.data.invoiceid });
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

            if (id > 0) {
                RequestLink = this.CreateRequestLink(action = 'chargeCaasify');
                let response = await axios.post(RequestLink, params);
                if (response?.data.data) {
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
            const params = { invoiceid: invoiceid };
            RequestLink = this.CreateRequestLink(action = 'markCancelInvoice');
            let response = await axios.post(RequestLink, params);
            if (response?.data.result == 'success') {
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

            const params = { invoiceid: invoiceid, chargeamount: chargeamountinWhmcs };

            if (invoiceid > 0) {
                RequestLink = this.CreateRequestLink(action = 'applyTheCredit');
                let response = await axios.post(RequestLink, params);

                if (response?.data.result == 'success') {
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











        // Create
        showImage(imageAddress = null) {
            let BackendUrl = this.BackendUrl
            if (imageAddress != null && BackendUrl != null) {
                let FullImageAddress = null;
                FullImageAddress = BackendUrl + '/' + imageAddress
                return FullImageAddress
            } else {
                return null
            }
        },

        normallizeRangeValues(percentage, min, max, step) {
            let value = Math.ceil(percentage / 100 * (max - min) / step) * step + min
            return value.toString()
        },

        validateInput() {
            // Regular expression to allow only English letters and numbers
            const pattern = /^[A-Za-z0-9]+$/;
            if (!pattern.test(this.themachinename)) {
                this.MachineNameValidationError = true;
                // Restore the previous valid value
                this.themachinename = this.MachineNamePreviousValue;
            } else {
                this.MachineNameValidationError = false;
                // Update the previous valid value
                this.MachineNamePreviousValue = this.themachinename;
            }

            if (!pattern.test(this.themachinessh)) {
                this.SshNameValidationError = true;
                // Restore the previous valid value
                this.themachinessh = this.SshNamePreviousValue;
            } else {
                this.SshNameValidationError = false;
                // Update the previous valid value
                this.SshNamePreviousValue = this.themachinessh;
            }
        },

        openConfirmDialog(title, text) {
            window.scrollTo({ top: 0, behavior: 'smooth' });
            // Open dialog
            this.confirmDialog = true

            // Content
            this.confirmText = text
            this.confirmTitle = title

            // Reset click Btn 
            this.createActionFailed = false
            this.createActionSucced = false
            this.userClickedCreationBtn = false

            // Promise
            return new Promise((resolve) => this.confirmResolve = resolve)

        },

        acceptConfirmDialog() {

            this.confirmResolve(true)

            // Close dialog
            this.confirmDialog = false

            // Check Click
            this.userClickedCreationBtn = true

        },

        closeConfirmDialog() {

            this.confirmResolve(false)

            // Close dialog
            this.confirmDialog = false


            // Reset Click BTN
            setTimeout(() => {
                this.createActionFailed = false
                this.createActionSucced = false
                this.userClickedCreationBtn = false
            }, 500);



        },

        openMessageDialog(text) {

            // Open dialog
            this.messageDialog = true

            // Content
            this.messageText = text

            // Promise
            return new Promise((resolve) => this.messageResolve = resolve)
        },

        closeMessageDialog() {

            this.messageResolve(false)

            // Close dialog
            this.messageDialog = false
        },

        showMachinePriceInWhmcsUnit(value) {
            let decimal = this.config.DefaultMonthlyDecimal
            return this.formatNumbers(value, decimal)
        },

        formatPrice(price, decimal = 2) {
            return Number(price).toFixed(decimal)
        },

        formatCostMonthly(value) {
            let decimal = this.config.DefaultMonthlyDecimal
            if (value < 99999999999999 && value != null) {
                if (value > 1) {
                    return value.toLocaleString('en-US', { minimumFractionDigits: decimal, maximumFractionDigits: decimal })
                } else if (value > 0.1) {
                    return value.toLocaleString('en-US', { minimumFractionDigits: 2, maximumFractionDigits: 2 })
                } else if (value > 0.01) {
                    return value.toLocaleString('en-US', { minimumFractionDigits: 3, maximumFractionDigits: 3 })
                } else if (value > 0.001) {
                    return value.toLocaleString('en-US', { minimumFractionDigits: 4, maximumFractionDigits: 4 })
                } else if (value > 0.0001) {
                    return value.toLocaleString('en-US', { minimumFractionDigits: 5, maximumFractionDigits: 5 })
                } else if (value > 0.00001) {
                    return value.toLocaleString('en-US', { minimumFractionDigits: 6, maximumFractionDigits: 6 })
                } else if (value > 0.000001) {
                    return value.toLocaleString('en-US', { minimumFractionDigits: 7, maximumFractionDigits: 7 })
                } else if (value > 0.0000001) {
                    return value.toLocaleString('en-US', { minimumFractionDigits: 8, maximumFractionDigits: 8 })
                } else if (value > 0.00000001) {
                    return value.toLocaleString('en-US', { minimumFractionDigits: 9, maximumFractionDigits: 9 })
                } else if (value > 0.000000001) {
                    return value.toLocaleString('en-US', { minimumFractionDigits: 10, maximumFractionDigits: 10 })
                } else {
                    return valuetoLocaleString('en-US')
                }
            } else {
                return null
            }
        },

        formatCostHourly(value) {
            let decimal = this.config.DefaultHourlyDecimal
            if (value < 99999999999999 && value != null) {
                value = value / (30 * 24)
                if (value > 1) {
                    return value.toLocaleString('en-US', { minimumFractionDigits: decimal, maximumFractionDigits: decimal })
                } else if (value > 0.1) {
                    return value.toLocaleString('en-US', { minimumFractionDigits: 2, maximumFractionDigits: 2 })
                } else if (value > 0.01) {
                    return value.toLocaleString('en-US', { minimumFractionDigits: 3, maximumFractionDigits: 3 })
                } else if (value > 0.001) {
                    return value.toLocaleString('en-US', { minimumFractionDigits: 4, maximumFractionDigits: 4 })
                } else if (value > 0.0001) {
                    return value.toLocaleString('en-US', { minimumFractionDigits: 5, maximumFractionDigits: 5 })
                } else if (value > 0.00001) {
                    return value.toLocaleString('en-US', { minimumFractionDigits: 6, maximumFractionDigits: 6 })
                } else if (value > 0.000001) {
                    return value.toLocaleString('en-US', { minimumFractionDigits: 7, maximumFractionDigits: 7 })
                } else if (value > 0.0000001) {
                    return value.toLocaleString('en-US', { minimumFractionDigits: 8, maximumFractionDigits: 8 })
                } else if (value > 0.00000001) {
                    return value.toLocaleString('en-US', { minimumFractionDigits: 9, maximumFractionDigits: 9 })
                } else if (value > 0.000000001) {
                    return value.toLocaleString('en-US', { minimumFractionDigits: 10, maximumFractionDigits: 10 })
                } else {
                    return valuetoLocaleString('en-US')
                }
            } else {
                return null
            }
        },

        async loadDataCenters() {
            RequestLink = this.CreateRequestLink(action = 'CaasifyGetDataCenters');
            let response = await axios.get(RequestLink);
            if (response?.data?.message) {
                this.DataCentersAreLoaded = true
                this.plansAreLoaded = false
                this.regionsAreLoaded = false
                console.error('can not find DataCenters');
            }
            if (response?.data?.data) {
                this.DataCentersLength = response?.data?.data.length;
                this.plansAreLoaded = false
                this.regionsAreLoaded = false
                this.DataCentersAreLoaded = true
                this.DataCenters = response?.data?.data
            }
        },

        selectDataCenter(DataCenter) {
            this.regionId = null
            this.plansLength = 0
            this.DataCenterName = DataCenter.name
            this.DataCenterID = DataCenter.id

            this.regionsAreLoaded = true
            this.regionIsSelected = false
            this.regions = DataCenter.categories
            this.regionsLength = 2
            
            this.makeNullAll()
        },

        isDataCenter(DataCenter) {
            if (this.DataCenterID == DataCenter.id) {
                return true
            } else {
                return false
            }
        },

        selectRegion(region) {
            this.plansLength = 0
            this.plansAreLoading = true
            if (this.regionId == region.id) {
                this.plansAreLoading = false
            }
            this.planIsSelected = false
            this.regionId = region.id
            this.regionName = region.name

            this.planId = null
            this.planTitle = null
            this.planDescription = null
            this.planPrice = null

            
            this.makeNullAll()
        },

        isRegion(region) {

            if (this.regionId == region.id) {
                return true
            } else {
                return false
            }

        },

        selectPlan(plan) {
            this.planIsSelected = true
            this.planId = plan.id
            this.planName = plan.title
            this.planPrice = plan.price

            this.FindSections()
        },

        isPlan(plan) {

            if (this.planId == plan.id) {
                return true
            } else {
                return false
            }
        },

       

        formatDescription(description) {
            return description.replace(/\n/g, "<br />");
        },

        async loadRullesFromGit() {
            try {
                let response = await axios.get('https://raw.githubusercontent.com/autovm-modules/AutoVM-WhModules-Reseller/main/modules/addons/cloudsnp/views/autovm/includes/baselayout/rulles.php');
                this.RullesText = response.data;
            } catch (error) {
                console.error('Error fetching the file:', error);
            }
        },

        async loadPlans() {
            this.plansAreLoaded = null;
            this.plans = [];
            let formData = new FormData();
            formData.append('CategoryID', this.regionId);


            RequestLink = this.CreateRequestLink(action = 'CaasifyGetPlans');
            let response = await axios.post(RequestLink, formData);
            this.plansAreLoading = true

            if (response?.data?.message) {
                this.plansAreLoading = false;
                this.plansAreLoaded = true;
                console.error('can not find any plans in this regin');
            }

            if (response?.data?.data) {
                this.plansLength = response?.data?.data.length;
                this.plansAreLoading = false;
                this.plansAreLoaded = true;
                this.plans = response?.data?.data
            }
        },

        async create() {
            let accept = await this.openConfirmDialog(this.lang('Create Machine'), this.lang('Are you sure about this?'))

            if (accept) {

                let formData = new FormData();
                formData.append('note', this.themachinename);
                formData.append('product_id', this.planId);
                
                let configs = this.PlanConfigSelectedOptions;
                for (let key in configs) {
                    formData.append(key, configs[key].value);
                }
                
                RequestLink = this.CreateRequestLink(action = 'CaasifyCreateOrder');
                let response = await axios.post(RequestLink, formData);
                response = response.data

                if (response?.data) {
                    this.createActionSucced = true
                } else if (response?.message) {
                    this.msg = response?.message
                    this.openMessageDialog(this.lang(response?.message))
                    this.createActionFailed = true
                } else {
                    this.createActionFailed = true
                }
            }
        },

        // view
        machineId() {
            let params = new URLSearchParams(window.location.search)
            this.machineID = params.get('id')
            return params.get('id')
        },

        findValidViews() {
            this.ValidViewItems = null;
            let views = this.views;
            for (var view of views) {
                if (view?.status == "completed" && view?.items?.length > 0 && this.ValidViewItems === null) {
                    this.ValidViewItems = view.items
                    this.NewViewStatus = 'completed';
                }
            }

            if (this.ValidViewItems === null) {
                this.NoValidViewItems = true
            }
        },

        FindSections() {
            this.PlanSectionsLoading = true
            let plans = this.plans
            let sections = null
            this.PlanConfigs = null
            if (plans != null) {
                for (var plan of plans) {
                    if (plan.id == this.planId && sections === null) {
                        sections = plan.sections
                        this.PlanSections = sections
                        this.PlanSectionsLoading = false
                        this.PlanSectionsLoaded = true
                    }
                }
            }

            if(sections != null){
                this.FindPlanConfigs()
            }
        },
        
        FindPlanConfigs() {
            let sections = this.PlanSections
            let PlanConfigs = null
            
            if (sections != null) {
                for (var section of sections) {
                    if (section.name == "Config") {
                        PlanConfigs = section.fields
                        this.PlanConfigs = PlanConfigs
                    }
                }
            }

            if (PlanConfigs != null) {
                this.EmptyPlanConfigs = false
                this.initPlanConfigSelectedOptions();
            }
        },

        findValidControllers() {
            this.ValidControllerItems = null;
            this.NoValidControllerItems = false            

            if(this.thisOrder?.records){
                let records = this.thisOrder.records;
                for(var i = 0; i < records?.length; i++){
                    let record = records[i];
                    if(record.status == "completed" && this.ValidControllerItems === null){
                        let groups = record.product.groups
                        for(var j = 0; j < groups.length; j++){
                            let group = groups[j]
                            if(group?.buttons && this.ValidControllerItems === null){
                                this.ValidControllerItems = group.buttons
                                this.ControllersAreLoading = false
                            }
                        }
                    }
                }
            }
            if(this.ValidControllerItems == null){
                this.NoValidControllerItems = true
            }
        },

        FindNameConfigFromValue(arrayName, value){
            for (const planConfig of this.PlanConfigs) {
                if (planConfig.name === arrayName && planConfig.options) {
                    const options = planConfig.options;
                    for (const option of options) {
                        if (option.value === value) {
                            return option.name;
                        }
                    }
                }
            }
            return null;
        },
        
        FindIDConfigFromValue(arrayName, value){
            for (const planConfig of this.PlanConfigs) {
                if (planConfig.name === arrayName && planConfig.options) {
                    const options = planConfig.options;
                    for (const option of options) {
                        if (option.value === value) {
                            return option.id;
                        }
                    }
                }
            }
            return null;
        },

        initPlanConfigSelectedOptions(){
            let PlanConfigs = this.PlanConfigs;
            this.PlanConfigSelectedOptions = {};

            if(PlanConfigs != null){
                for(let PlanConfig of PlanConfigs){
                    this.PlanConfigSelectedOptions[PlanConfig.name] = 'empty'
                }
            }
        },
        
        makeNullAll(){
            this.FindSections()
            this.FindPlanConfigs()
            this.initPlanConfigSelectedOptions()
        },


        SumConfigPrice(){
            let ConfigPrice = 0
            let PlanConfigSelectedOptions = this.PlanConfigSelectedOptions
            
            for (let key in PlanConfigSelectedOptions) {
                if (PlanConfigSelectedOptions.hasOwnProperty(key)) {
                    let price = parseFloat(PlanConfigSelectedOptions[key].price);
                    if (!isNaN(price)) {
                        ConfigPrice += price;
                    }
                }
            }
            
            return ConfigPrice
        },

        async LoadOrderViews() {
                let machineID = this.machineID;
                if (machineID != null) {
                    let formData = new FormData();
                    formData.append('machineID', machineID);
                    this.viewsAreLoading = true

                    RequestLink = this.CreateRequestLink(action = 'CaasifyGetOrderViews');
                    let response = await axios.post(RequestLink, formData);

                    if (response?.data?.message) {
                        this.viewsAreLoading = false;
                        this.viewsAreLoaded = true;
                        console.error('can not find any views');
                    }

                    if (response?.data?.data) {
                        this.viewsAreLoading = false;
                        this.viewsAreLoaded = true;
                        this.views = response?.data?.data
                        this.findValidViews()
                    }
                }
        },

        async LoadRequestNewView() {
            this.NewViewStatus = null;

            let machineID = this.machineID;
            if (machineID != null) {
                let formData = new FormData();
                formData.append('machineID', machineID);

                RequestLink = this.CreateRequestLink(action = 'CaasifyRequestNewView');
                let response = await axios.post(RequestLink, formData);

                if (response?.data?.message) {
                    console.error('can not reguest new view');
                }

                if (response?.data?.data) {
                    this.NewViewStatus = response?.data?.data?.status
                    this.LoadOrderViews();
                    console.log('reguest new view done');
                }
            }
        },


        }
});

app.config.compilerOptions.isCustomElement = tag => tag === 'btn'
app.mount('#app') 