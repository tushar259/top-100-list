<template>
    <div>
        <input type="text" v-model="email" placeholder="email"><br>
        <input type="password" v-model="password" placeholder="Password"><br><br>
        <button @click="loginClicked()">Login</button>
    </div>
</template>

<script>
export default {
    data(){
        return{
            email: '',
            password: ''
        };
    },

    methods:{
        loginClicked(){
            if(this.email.trim() == "" || this.password.trim() == ""){

            }
            else{
                this.email = this.email.replace(/</g, '');
                this.password = this.password.replace(/</g, '');
                const formData = new FormData();
                formData.append('email', this.email);
                formData.append('password', this.password);
                axios.post('/api/going-to-log-in', formData)
                .then(response =>{
                    console.log(response);
                    if(response.data.success == true){
                        this.$router.push('/add-new-component');
                    }
                })
                .catch(error =>{

                });
            }
        }
    }
};
</script>