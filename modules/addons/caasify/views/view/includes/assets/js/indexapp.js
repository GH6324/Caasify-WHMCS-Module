const { createApp } = Vue

app = createApp({

    data() {
        return {            
            PanelLanguage: null,
            configs: [],
            systemUrl: null,
            UserOrders: null,
            CaasifyUserInfo: null,
            WhmcsUserInfo: null,
            WhmcsCurrencies: null,
        }
    },

    watch: {
      systemUrl(newsystemUrl){
        if(newsystemUrl != ''){
          this.LoadUserOrders();
          this.readLanguageFirstTime();
          this.LoadCaasifyUser();
          this.LoadWhmcsUser();
          this.LoadWhmcsCurrencies();
        }
      }
    },

    mounted(){
      this.fetchModuleConfig();
    },

    computed:{
    },

    methods: { 
      fetchModuleConfig() {
        fetch('configApi.php')  // Use a relative path to reference the PHP file
          .then(response => response.json())
          .then(data => { 
            this.configs = data.configs;
            this.systemUrl = data.configs.systemUrl;
            if(this.systemUrl == ''){
              console.log('systemUrl is empty');
            } 
          })
          .catch(error => {
            console.error('Error fetching root directory address:');
          });
      },

      readLanguageFirstTime(){
        this.PanelLanguage = this.getCookieValue('temlangcookie');
      },

      changeLanguage(){
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
      
      CreateRequestLink(action){
        let systemUrl = this.systemUrl;
        let RequestLink = systemUrl + '/index.php?m=caasify&action=' + action;
        return RequestLink;
      },
       
      async LoadUserOrders(){
        RequestLink = this.CreateRequestLink(action = 'UserOrders');
        let response = await axios.get(RequestLink);
        if(response?.data.data){
          this.UserOrders = response.data.data
        } else if (response?.data.message) {
          console.log('UserOrders: ' + response.data.message);
        }
      },
      
      async LoadCaasifyUser(){        
        RequestLink = this.CreateRequestLink(action = 'CaasifyUserInfo');
        let response = await axios.get(RequestLink);
        if(response?.data.data){
          this.CaasifyUserInfo = response.data.data
        } else if (response?.data.message) {
          console.log('CaasifyUserInfo: ' + response.data.message);
        }
      },

      async LoadWhmcsUser(){        
        RequestLink = this.CreateRequestLink(action = 'WhmcsUserInfo');
        let response = await axios.get(RequestLink);
        if(response?.data){
          this.WhmcsUserInfo = response.data
        } else {
          console.log('WhmcsUserInfo: ' + 'no response');
        }
      },
      
      async LoadWhmcsCurrencies(){        
        RequestLink = this.CreateRequestLink(action = 'WhmcsCurrencies');
        let response = await axios.get(RequestLink);
        if(response?.data){
          this.WhmcsCurrencies = response.data
        } else {
          console.log('WhmcsCurrencies: ' + 'no response');
        }
      },

    }
});

app.config.compilerOptions.isCustomElement = tag => tag === 'btn'
app.mount('#indexapp') 