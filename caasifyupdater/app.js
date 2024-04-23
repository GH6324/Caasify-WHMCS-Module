const { createApp } = Vue

  createApp({
    data() {
      return {
        iframeAddress : '/caasifyupdatepage.php',
        ActonResponse : null,
        ChoseVersion: null,
        HardDeleteVisible: false,


        confirmDialog: false,
        actionWouldBeHappened: null,
      }
    },

    methods: {
        ChangeShowHardDelete(){
          this.HardDeleteVisible = !this.HardDeleteVisible;
          console.log(this.HardDeleteVisible);
        },

        // async funcDelete() {
        //   let accept = await this.openConfirmDialog('Delete')
          
        //   if (accept) {
        //     axios.post('./caasifyupdatefunc.php', {funcmethod: 'delete'})
        //     .then(response => {
        //       // Handle the response from the server
        //       this.ActonResponse = response.data
        //     })
        //     .catch(error => {
        //       // Handle errors
        //       this.ActonResponse = error;
        //     });
        //   }
        // },
        
        // async funchardDelete() {
        //   let accept = await this.openConfirmDialog('Hard Delete')
          
        //   if (accept) {
        //     axios.post('./caasifyupdatefunc.php', {funcmethod: 'hardDelete'})
        //     .then(response => {
        //       // Handle the response from the server
        //       this.ActonResponse = response.data
        //       window.parent.location.reload();
        //     })
        //     .catch(error => {
        //       // Handle errors
        //       this.ActonResponse = error;
        //     });
        //   }
        // },

        async funcInstall() {
          let accept = await this.openConfirmDialog('Install')
          
          if (accept) {
            axios.post('./caasifyupdatefunc.php', {funcmethod: 'install'})
            .then(response => {
              // Handle the response from the server
              this.ActonResponse = response.data
            })
            .catch(error => {
              // Handle errors
              this.ActonResponse = error;
            });
          }
        },

        async funcUpdate() {
          let accept = await this.openConfirmDialog('Update')
          
          if (accept) {
            axios.post('./caasifyupdatefunc.php', {funcmethod: 'update'})
            .then(response => {
              // Handle the response from the server
              this.ActonResponse = response.data
            })
            .catch(error => {
              // Handle errors
              this.ActonResponse = error;
            });
          }
        },
        
        async funcFix() {
          let accept = await this.openConfirmDialog('Fix Permission')
          
          if (accept) {
            axios.post('./caasifyupdatefunc.php', {funcmethod: 'fix'})
            .then(response => {
              // Handle the response from the server
              this.ActonResponse = response.data
            })
            .catch(error => {
              // Handle errors
              this.ActonResponse = error;
            });
          }
        },

        async funcDownload() {
          let accept = await this.openConfirmDialog('Download')
          
          if (accept) {
            axios.post('./caasifyupdatefunc.php', {funcmethod: 'download'})
            .then(response => {
              // Handle the response from the server
              this.ActonResponse = response.data
            })
            .catch(error => {
              // Handle errors
              this.ActonResponse = error;
            });
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

    },

  }).mount('#app')