const { createApp } = Vue

app = createApp({

    data() {
        return {

            

            // views
            orderID: null,
            thisProduct:null,
            thisOrder: null,
            ordeIsLoaded: null,

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
            
            actionWouldBeHappened:null,
            ActionAlert: null,
            ActionAlertStatus: null,
            ActionHistory: null,
            ActionHistoryIsLoaded: null,
            





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
            UserOrders: [],
            userHasNoOrder: false,
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
            CreateMSG: null,
            RullesText: null,


            DataCenters: [],            
            SelectedDataCenter: null,
            DataCentersAreLoaded: false,
            DataCentersLength: 0,

            regions: [],
            SelectedRegion: null,

            plans: [],
            SelectedPlan: null,
            plansAreLoaded: false,
            plansAreLoading: false,
            

            PlanSections: null,
            PlanConfigSelectedOptions: {},

            



            
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
                    this.CreateRandomHostName()
                    this.LoadCaasifyUser();
                    this.LoadWhmcsUser();
                    this.LoadWhmcsCurrencies();
                    this.loadDataCenters();
                    this.readLanguageFirstTime();

                } else if (newFielName == "view.php") {
                    this.orderId();
                    this.LoadTheOrder();
                    this.readLanguageFirstTime();
                    this.LoadCaasifyUser();
                    this.LoadWhmcsUser();
                    this.LoadWhmcsCurrencies();
                    
                    this.loadPollingViewMachine()
                }
            }
        },

        orderID(neworderID) {
            if (neworderID != '') {
                this.LoadRequestNewView();
                this.LoadActionsHistory();
            }
        },

        systemUrl(newsystemUrl) {
            if (newsystemUrl != '') {
                this.loadUrl();
            }
        },

        SelectedRegion() {
            this.loadPlans()
        },

    },

    mounted() {
        this.scrollToTop();
        this.fetchModuleConfig();
    },

    computed: {

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
                let value = this.convertFromWhmcsToCloud(this.chargeAmountinWhmcs)
                return value
            } else {
                return null
            }
        },

        UserCreditInCaasifyCurrency() {
            if (this.userCreditinWhmcs != null && this.CurrenciesRatioWhmcsToCloud != null) {
                let value = this.convertFromWhmcsToCloud(this.userCreditinWhmcs)
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
            let NewMachinePrice = null
            let decimal = this.config.DefaultMonthlyDecimal

            if(this.SelectedPlan?.price != null && this.SumConfigPrice() != null){
                let planPrice = this.SelectedPlan.price
                let ConfigPrice = this.SumConfigPrice()

                let planPriceFloat = parseFloat(planPrice);
                let ConfigPriceFloat = parseFloat(ConfigPrice);

                if (!isNaN(planPriceFloat) && !isNaN(ConfigPriceFloat)) {
                    NewMachinePrice = planPriceFloat + ConfigPriceFloat;
                }
            }

            return NewMachinePrice
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
                    if (this.systemUrl.endsWith('/')) {
                        this.systemUrl = this.systemUrl.slice(0, -1);
                    }

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
            let page = 1;
            let reachEndPage = false
            this.UserOrders = []
            
            while (!reachEndPage) {
                let formData = new FormData();
                formData.append('page', page);    
                let RequestLink = this.CreateRequestLink(action = 'UserOrders');
                let response = await axios.post(RequestLink, formData);
                
                if (response.data?.data != null) {
                    this.UserOrders = this.UserOrders.concat(response.data.data);
                    this.machinsLoaded = true;
                } else if (response.data?.message) {
                    reachEndPage = true;
                    this.machinsLoaded = true;
                }
                
                page += 1;
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

        scrollToTop() {
            const topElement = document.getElementById('top');
            if (topElement) {
                topElement.scrollIntoView({ behavior: 'smooth' });
            }
        },

        scrollToRegions() {
            const Element = document.getElementById('RegionsPoint');
            if (Element) {
                Element.scrollIntoView({ behavior: 'smooth' });
            }
        },

        scrollToPlans() {
            const Element = document.getElementById('plansPoint');
            if (Element) {
                Element.scrollIntoView({ behavior: 'smooth' });
            }
        },

        scrollToConfig() {
            const Element = document.getElementById('configsPoint');
            if (Element) {
                Element.scrollIntoView({ behavior: 'smooth' });
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

        ConvertFromWhmcsToCloud(value) {
            if (this.CurrenciesRatioWhmcsToCloud) {
                let ratio = this.CurrenciesRatioWhmcsToCloud
                return value * ratio
            } else {
                return null
            }
        },

        ConvertFromCaasifyToWhmcs(value) {
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
            let base = ''
            if(this.systemUrl != null){
                base = this.systemUrl
            }
            let address = base + '/modules/addons/caasify/views/view/view.php'
            let params = new URLSearchParams({
                'id': order.id
            }).toString()
            window.open([address, params].join('?'), "_top")
        },
        
        openCreatePage() {
            let base = ''
            if(this.systemUrl != null){
                base = this.systemUrl
            }
            let address = base + '/modules/addons/caasify/views/view/create.php'
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
            const chargeamountInAutovm = this.convertFromWhmcsToCloud(this.ConstChargeamountInWhmcs.value);
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
                if (this.themachinename.trim() !== '') {
                    this.themachinename = this.MachineNamePreviousValue;
                }
            } else {
                this.MachineNameValidationError = false;
                // Update the previous valid value
                this.MachineNamePreviousValue = this.themachinename;
            }

            if (!pattern.test(this.themachinessh)) {
                this.SshNameValidationError = true;
                if (this.themachinessh.trim() !== '') {
                    this.themachinessh = this.SshNamePreviousValue;
                }
            } else {
                this.SshNameValidationError = false;
                // Update the previous valid value
                this.SshNamePreviousValue = this.themachinessh;
            }
        },

        openConfirmDialog(action) {
            this.actionWouldBeHappened = action
            return new Promise((resolve) => this.confirmResolve = resolve)
        },

        acceptConfirmDialog() {
            this.confirmResolve(true)
        },

        closeConfirmDialog() {
            this.confirmResolve(false)
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
            this.DataCentersAreLoaded = false

            RequestLink = this.CreateRequestLink(action = 'CaasifyGetDataCenters');
            let response = await axios.get(RequestLink);
            if (response?.data?.message) {
                this.DataCentersAreLoaded = true
                this.plansAreLoaded = false
                console.error('can not find DataCenters');
            }
            if (response?.data?.data) {
                this.DataCentersLength = response?.data?.data.length;
                this.DataCentersAreLoaded = true
                this.plansAreLoaded = false
                this.DataCenters = response?.data?.data
            }
        },

        selectDataCenter(DataCenter) {
            this.scrollToRegions()
            this.PlanConfigSelectedOptions = {}
            this.plans = [];
            this.SelectedPlan = null
            this.SelectedRegion = null
            this.PlanSections = null
            this.SelectedDataCenter = DataCenter
            this.regions = DataCenter.categories
        },
        
        isDataCenter(DataCenter) {
            if (this.SelectedDataCenter == DataCenter) {
                return true
            } else {
                return false
            }
        },

        selectRegion(region) {
            this.scrollToPlans();

            this.PlanConfigSelectedOptions = {}
            this.plans = [];
            this.SelectedPlan = null
            this.plansAreLoading = true
            this.plansAreLoaded = false
            this.PlanSections = null

            this.SelectedRegion = region
        },

        isRegion(region) {
            if (this.SelectedRegion == region) {
                return true
            } else {
                return false
            }
        },

        selectPlan(plan) {
            this.scrollToConfig()
            this.PlanConfigSelectedOptions = {}
            this.SelectedPlan = plan
            this.PlanSections = null
            if(this.SelectedPlan != null && this.SelectedPlan?.sections){
                this.PlanSections = this.SelectedPlan?.sections
            }
            this.initPlanConfigSelectedOptions()
        },

        isPlan(plan) {
            if (this.SelectedPlan == plan) {
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
            this.plansAreLoaded = false;
            this.plansAreLoading = true
            this.plans = [];

            if(this.SelectedRegion?.id){
                let formData = new FormData();
                formData.append('CategoryID', this.SelectedRegion?.id);
                RequestLink = this.CreateRequestLink(action = 'CaasifyGetPlans');
                let response = await axios.post(RequestLink, formData);
                
                if (response?.data?.message) {
                    this.plansAreLoading = false;
                    this.plansAreLoaded = true;
                    console.error('can not find any plans in this regin');
                }

                if (response?.data?.data) {
                    this.plansAreLoading = false;
                    this.plansAreLoaded = true;
                    this.plans = response?.data?.data
                }
            }
        },

        async create() {
            this.scrollToTop();

            let accept = await this.openConfirmDialog('create')

            if (accept) {
                let formData = new FormData();
                formData.append('note', this.themachinename);
                formData.append('product_id', this.SelectedPlan.id);
                
                let configs = this.PlanConfigSelectedOptions;
                for (let key in configs) {
                    if(configs[key].hasOwnProperty('value')){ // type dropdown
                        formData.append(key, configs[key].value);
                    } else if(configs[key].hasOwnProperty('options')){ // type text
                        formData.append(key, configs[key].options);
                    }
                }                

                RequestLink = this.CreateRequestLink(action = 'CaasifyCreateOrder');
                let response = await axios.post(RequestLink, formData);

                
                response = response.data

                if (response?.data) {
                    this.userClickedCreationBtn = true
                    this.createActionSucced = true
                } else if (response?.message) {
                    this.CreateMSG = response?.message
                    this.openMessageDialog(this.lang(response?.message))
                    this.createActionFailed = true
                } else {
                    this.createActionFailed = true
                }
            }
        },

        // view
        orderId() {
            let params = new URLSearchParams(window.location.search)
            this.orderID = params.get('id')
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

        findValidControllers() {
            this.ValidControllerItems = null;
            this.NoValidControllerItems = false            

            if(this.thisOrder?.records){
                let records = this.thisOrder.records;
                for(var i = 0; i < records?.length; i++){
                    let record = records[i];
                    if(this.ValidControllerItems === null){
                        this.thisProduct = record.product
                        let groups = record.product.groups
                        for(var j = 0; j < groups.length; j++){
                            let group = groups[j]
                            if (group?.buttons) {
                                if (this.ValidControllerItems === null) {
                                    this.ValidControllerItems = [];
                                }
                                this.ValidControllerItems = this.ValidControllerItems.concat(group.buttons);
                                this.ControllersAreLoading = false;
                            }
                        }
                    }
                }
            }
            if(this.ValidControllerItems == null){
                this.NoValidControllerItems = true
            }
        },

        initPlanConfigSelectedOptions(){
            this.PlanConfigSelectedOptions = {};
            if(this.PlanSections != null && Array.isArray(this.PlanSections)){
                for(let PlanSection of this.PlanSections){
                    for(let field of PlanSection.fields){
                        if(field?.type == 'dropdown'){
                            this.PlanConfigSelectedOptions[field.name] = field.options[0]
                        } else if (field?.type == 'text'){
                            this.PlanConfigSelectedOptions[field.name] = field
                        }
                    }
                }
            }
        },

        SumConfigPrice(){
            let ConfigPrice = 0
            let obj = this.PlanConfigSelectedOptions

            for (let key in obj) {
                if (obj.hasOwnProperty(key)) {
                    let price = parseFloat(obj[key]?.price);
                    if (!isNaN(price)) {
                        ConfigPrice += price;
                    }
                }
            }

            return ConfigPrice
        },







        // View Machine
        async LoadTheOrder() {
            let orderID = this.orderID;
            if (orderID != null) {
                let formData = new FormData();
                formData.append('orderID', orderID);
                        
                RequestLink = this.CreateRequestLink(action = 'LoadOrder');
                let response = await axios.post(RequestLink, formData);

                if (response.data?.data != null) {
                    this.thisOrder = response.data.data
                    this.ordeIsLoaded = true

                } else if (response.data?.message) {
                    this.ordeIsLoaded = true
                    if (response?.data.message == "There is nothing.") {
                        this.userHasNoOrder = true;
                    } else {
                        console.error('UserOrders: ' + response.data.message);
                    }
                }
            }
        },

        async LoadOrderViews() {
                let orderID = this.orderID;
                if (orderID != null) {
                    let formData = new FormData();
                    formData.append('orderID', orderID);
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
                        this.LoadActionsHistory()
                    }
                }
        },

        async LoadRequestNewView() {
            this.NewViewStatus = null;

            let orderID = this.orderID;
            if (orderID != null) {
                let formData = new FormData();
                formData.append('orderID', orderID);

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

        async LoadActionsHistory() {
            let orderID = this.orderID;
            this.ActionHistoryIsLoaded = null

            if (orderID != null) {
                let formData = new FormData();
                formData.append('orderID', orderID);
                RequestLink = this.CreateRequestLink(action = 'CaasifyActionsHistory');
                let response = await axios.post(RequestLink, formData);

                if (response?.data?.message) {
                    this.ActionHistoryIsLoaded = true
                    console.error('can not reguest Action History');
                }

                if (response?.data?.data) {
                    this.ActionHistory = response?.data?.data
                    this.ActionHistoryIsLoaded = true
                }
            }
            
        },
        
        async PushButtonController(button_id, button_name) {
            this.ActionAlertStatus = null
            this.ActionAlert = null

            let accept = await this.openConfirmDialog(button_name)

            if (accept) {
                let orderID = this.orderID;
                if (orderID != null && button_id != null) {
                    let formData = new FormData();
                    formData.append('orderID', orderID);
                    formData.append('button_id', button_id);

                    RequestLink = this.CreateRequestLink(action = 'CaasifyOrderDoAction');
                    let response = await axios.post(RequestLink, formData);

                    if (response?.data?.message) {
                        this.LoadActionsHistory()
                        this.ActionAlertStatus = 'failed'
                        this.ActionAlert = response?.data?.message
                        console.error('can not send action');
                    }

                    if (response?.data?.data) {
                        this.LoadActionsHistory()
                        this.ActionAlertStatus = 'success'
                        this.ActionAlert = button_name + ' has send Successfully'
                        this.findValidViews()
                    }
                }

                setTimeout(() => {
                    this.ActionAlertStatus = null
                    this.ActionAlert = null
                    this.LoadActionsHistory()
                }, 4000);

            }
        },

        loadPollingViewMachine() {
            setInterval(this.LoadRequestNewView, 22230000)
        },

        MachineSpendTime(timeVariable) {
            const creationDate = new Date(timeVariable);
            const currentDate = new Date();
            const timeDifference = currentDate - creationDate;
            const totalMinutes = Math.floor(timeDifference / (1000 * 60));
            const hours = Math.floor(totalMinutes / 60);
            const minutes = totalMinutes % 60;

            let duration = '1min';

            if (hours > 0 && minutes > 0) {
                duration = `${hours}hr ${minutes}min`;
            } else if (hours > 0) {
                duration = `${hours}hr`;
            } else {
                duration = `${minutes}min`;
            }
              
            return duration
        },

        convertTime(time) {
            const formatDate = (dateString) => {
              const date = new Date(dateString);
              const months = [
                "Jan", "Feb", "Mar", "Apr", "May", "Jun",
                "Jul", "Aug", "Sep", "Oct", "Nov", "Dec"
              ];
              const day = date.getDate();
              const month = months[date.getMonth()];
              const hours = String(date.getHours()).padStart(2, "0");
              const minutes = String(date.getMinutes()).padStart(2, "0");
              
              return `${day} ${month} at ${hours}:${minutes}`;
            };
            
            return formatDate(time);
        },

        CreateRandomHostName(){
            const length = 7;
            const letters = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
            let result = '';
            for (let i = 0; i < length; i++) {
                result += letters.charAt(Math.floor(Math.random() * letters.length));
            }
            this.themachinename = result;
        },
    }
});

app.config.compilerOptions.isCustomElement = tag => tag === 'btn'
app.mount('#app') 