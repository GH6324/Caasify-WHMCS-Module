const { createApp } = Vue

app = createApp({

    data() {
        return {
            readyToLoad: null,
            WhUserId: null,
            
            CaasifyConfigs: [],
            config: {
                BackendUrl: null,
                DefLang: null,
                CaasifyCurrency: null,
                CloudTopupLink: null,
                AdminClientsSummaryLink: null,
                ChargeModule: null,
                ViewExchanges: null,
                MinimumCharge: null,
                MaximumCharge: null,
                MinBalanceAllowToCreate: null,
                MonthlyCostDecimal: null,
                HourlyCostDecimal: null,
                BalanceDecimal: null,
                DevelopeMode: null,
                DemoMode: null,
                errorMessage: null,
                systemUrl: null,
            },

            CaasifyUserInfo: null,
            UserInfoIsLoaded: false,
            UserInfoIsLoading: false,
            
            CaasifyResellerInfo: null,
            ResellerInfoIsLoaded: null,
            
            
            UserOrders: null,
            UserOrdersIsLoaded: false,
            UserOrdersIsLoading: false,
            



            ChargeAmount: null,
            ChargingIsInProcess: false,
            ChargingResponse: {
                data: null,
                message: null
            },

        }
    },
    
    mounted() {
        this.fetchModuleConfig();
        this.getUserId();
        this.loadPolling()
    },       

    watch: {
        CaasifyConfigs(NewCaasifyConfigs) {
            this.config.BackendUrl = NewCaasifyConfigs.BackendUrl
            this.config.DefLang = NewCaasifyConfigs.DefLang
            this.config.CaasifyCurrency = NewCaasifyConfigs.CaasifyCurrency
            this.config.CloudTopupLink = NewCaasifyConfigs.CloudTopupLink
            this.config.AdminClientsSummaryLink = NewCaasifyConfigs.AdminClientsSummaryLink
            this.config.ChargeModule = NewCaasifyConfigs.ChargeModule
            this.config.ViewExchanges = NewCaasifyConfigs.ViewExchanges
            this.config.MinimumCharge = NewCaasifyConfigs.MinimumCharge
            this.config.MaximumCharge = NewCaasifyConfigs.MaximumCharge
            this.config.MinBalanceAllowToCreate = NewCaasifyConfigs.MinBalanceAllowToCreate
            this.config.MonthlyCostDecimal = NewCaasifyConfigs.MonthlyCostDecimal
            this.config.HourlyCostDecimal = NewCaasifyConfigs.HourlyCostDecimal
            this.config.BalanceDecimal = NewCaasifyConfigs.BalanceDecimal
            this.config.DevelopeMode = NewCaasifyConfigs.DevelopeMode
            this.config.DemoMode = NewCaasifyConfigs.DemoMode
            this.config.errorMessage = NewCaasifyConfigs.errorMessage
            this.config.systemUrl = NewCaasifyConfigs.systemUrl
            
            this.checkReadyToLoad();
        },

        getUserId(newGetUserId) {
            this.checkReadyToLoad();
        },

        readyToLoad(newValue){
            if(newValue == true){
                this.LoadCaasifyReseller();
                this.LoadCaasifyUser();
                this.LoadUserOrders();
            }
        },
    },

    computed: {
        
    },

    methods: {
        fetchModuleConfig() {
            fetch('configApi.php')  // Use a relative path to reference the PHP file
                .then(response => response.json())
                .then(data => {
                    this.CaasifyConfigs = data.configs;
                })
                .catch(error => {
                    console.error('Error fetching Config API');
                });
        },

        getUserId() {
            let params = new URLSearchParams(window.location.search);
            let userid = params.get('userid');
            if(userid != null){
                this.WhUserId = userid
            } else {
                console.error('WhUserId did not found');
                this.WhUserId = null
            }
        },

        checkReadyToLoad() {
            if (this.config?.AdminClientsSummaryLink != null && this.WhUserId != null) {
                this.readyToLoad = true;   
            } else {
                console.log('AdminLink or UserId is missed');
            }
        },

        CreateRequestLink(action) {
            let AdminClientsSummaryLink = this.config.AdminClientsSummaryLink;
            if(AdminClientsSummaryLink == null){
                AdminClientsSummaryLink = '/admin/clientssummary.php';
            }
            
            let WhUserId = this.WhUserId;
            if(WhUserId == null){
                console.error('can not find UserId to run ajax');   
                return null;
            }

            let RequestLink = AdminClientsSummaryLink + '?userid=' + WhUserId + '&action=' + action;
            return RequestLink;
        },

        openChargingDialogue(){
            this.ChargingResponse.data = null
            this.ChargingResponse.message = null
            
            $('#ModalChargingAdmin').modal('show');
        },

        async LoadCaasifyUser() {
            this.UserInfoIsLoading = true
            RequestLink = this.CreateRequestLink(action = 'admin_CaasifyUserInfo');
            if(RequestLink == null){
                console.error('LoadCaasifyUser: Creating the link cause error');
                return 'LoadCaasifyUser: Creating the link cause error'
            }

            let response = await axios.get(RequestLink);
            if (response?.data){
                this.UserInfoIsLoading = false
            }

            if (response?.data?.data) {
                this.UserInfoIsLoaded = true
                this.CaasifyUserInfo = response.data.data
            } else if (response?.data?.message) {
                this.UserInfoIsLoaded = true
                console.error('CaasifyUserInfo: ' + response.data.message);
            } else {
                console.error('CaasifyUserInfo returns NULL');
            }
        },
        
        async LoadUserOrders() {
            this.UserOrdersIsLoading = true;

            RequestLink = this.CreateRequestLink(action = 'admin_UserOrders');
            if(RequestLink == null){
                console.error('LoadUserOrders: Creating the link cause error');
                return 'LoadUserOrders: Creating the link cause error'
            }

            let response = await axios.get(RequestLink);
            if (response?.data){
                this.UserOrdersIsLoaded = true;
                this.UserOrdersIsLoading = false;
            }

            if (response?.data?.data) {
                this.UserOrders = response.data.data
            } else if (response?.data?.message) {
                console.error('UserOrders: ' + response.data.message);
            } else {
                console.error('UserOrders returns NULL');
            }
        },

        async chargeCaasify() {
            const ChargeAmount = this.ChargeAmount;
            const params = {
                ChargeAmount: ChargeAmount,
            };

            this.ChargingIsInProcess = true
            RequestLink = this.CreateRequestLink(action = 'admin_chargeCaasify');
            let response = await axios.post(RequestLink, params);

            if(response) {
                this.ChargeAmount = null
                this.ChargingIsInProcess = false
                console.log(response);
            }
            
            if (response?.data?.data) {
                this.ChargingResponse.data = response?.data?.data
            } else {
                if (response?.data?.message) {
                    this.ChargingResponse.message = response?.data?.message
                } else {
                    this.ChargingResponse.message = 'unknown'
                    console.error('unknown');
                }
            }
        },

        async LoadCaasifyReseller() {
            RequestLink = this.CreateRequestLink(action = 'admin_CaasifyRessellerInfo');
            if(RequestLink == null){
                console.error('LoadCaasifyReseller: Creating the link cause error');
                return 'LoadCaasifyReseller: Creating the link cause error'
            }

            let response = await axios.get(RequestLink);
            if (response?.data?.data) {
                this.ResellerInfoIsLoaded = true
                this.CaasifyResellerInfo = response.data.data
            } else if (response?.data?.message) {
                this.ResellerInfoIsLoaded = true
                console.error('CaasifyResellerInfo: ' + response.data.message);
            } else {
                console.error('CaasifyResellerInfo returns NULL');
            }
        },

        loadPolling(){
            setInterval(this.LoadCaasifyReseller, 20 * 1000)
            setInterval(this.LoadCaasifyUser, 20 * 1000)
            setInterval(this.LoadUserOrders, 20 * 1000)
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
    }
});


app.mount('.adminapp') 