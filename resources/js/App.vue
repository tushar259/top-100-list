<template>
    
    <nav class="navbar navbar-expand-lg navbar-light" style="width: 100% !important">
        <!-- <a class="navbar-brand" href="#"> -->
        <div style="width: 170px;">
            <img class="navbar-brand navbar-logo-custom" src="/logo/favicon2.png" alt="top 100 list logo">
        </div>
        <!-- </a> -->
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="navbar-collapse collapse" id="navbarNav">
            <ul class="navbar-nav">
                <li class="nav-item">
                    <router-link class="nav-link text-capitalize" to="/">Home</router-link>
                </li>
                <li class="nav-item" v-for="navigLlink in navlinks" :key="navigLlink.id">
                    <a class="nav-link text-capitalize" :href="'/'+navigLlink.table_name_starts_with" @click="handleLinkClick(navigLlink.table_name_starts_with)">{{navigLlink.nav_headline}}</a>
                </li>
                
                
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle text-truncate" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        More..
                    </a>
                    <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                        <!-- <router-link class="dropdown-item" to="" :class="{ 'active': activeLink === 'hollywood' }" @click="collapse = true,activeLink = 'hollywood'">Hollywood</router-link>
                        <router-link class="dropdown-item" to="" :class="{ 'active': activeLink === 'football' }" @click="collapse = true,activeLink = 'football'">Football</router-link> -->
                        <a class="dropdown-item text-capitalize" v-for="(navigLlink, index) in navSublinks" :key="index" :href="'/'+navigLlink.table_name_starts_with" >{{navigLlink.nav_headline}}</a>
                        
                        <!-- <div class="dropdown-divider"></div> -->
                    </div>
                </li>
                
                
            </ul>
            <hr class="my-1">
            <ul class="navbar-nav ml-auto"> <!-- d-none -->
                <li class="nav-item search-nav-item">
                    <input class="form-control nav-search-input" id="searchedData" v-model="searchItem" @keyup="saveSearchedItem()" @keyup.enter="gotoSearchPage()" placeholder="Search...">
                    
                </li>
                <li class="nav-item">
                    <a class="btn btn-secondary nav-search-button" :href="'/search/'+searchItem" >Search</a>
                </li>
            </ul>
            <!-- <ul class="navbar-nav ml-auto">
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle text-truncate" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" >
                        UserEmail here
                    </a>
                    <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                        <router-link class="dropdown-item" to="/change-password">Change password</router-link>
                        
                        <div class="dropdown-divider"></div>
                        <router-link  class="dropdown-item" to="">Logout</router-link>
                    </div>
                </li>
            </ul> -->
        </div>
    </nav>
    <div class="content">
        <router-view/>
    </div>
    
</template>

<script>
import AllComponent from './components/AllComponent.vue';
import {router} from './router.js';

export default {
    name: 'App',
    data(){
        return{
            navlinks: [],
            navSublinks: [],
            searchItem: localStorage.getItem('searchedItem'),
        };
    },

    created(){
        this.loadNavlinksFromLocalStorage();
        this.getRoutes();
    },

    methods:{
        loadNavlinksFromLocalStorage() {
            const navlinksString = localStorage.getItem('navlinks');
            if (navlinksString) {
                this.navlinks = JSON.parse(navlinksString);
            }
        },
        getRoutes(){
            axios.get('/api/get-all-routes-for-nav')
            .then(response =>{
                console.log(response);
                if(response.data.success == true){
                    this.navlinks = [];
                    this.navSublinks = [];
                    if(response.data.allData != null){
                        response.data.allData.forEach(item => {
                            this.navlinks.push(item);
                        });
                    }
                    if(response.data.childs != null){
                        response.data.childs.forEach(item => {
                            this.navSublinks.push(item);
                        });
                    }
                    localStorage.setItem('navlinks', JSON.stringify(this.navlinks));
                }
            })
            .catch(error =>{

            });
        },

        handleLinkClick(linkText) {
            this.$router.push('/'+linkText);
            // this.$nextTick(() => {
            //     AllComponent.created(); // Call the created method in the AllComponent component
            //     // AllComponent.methods.getAllData.call(this);
            // });
        },

        saveSearchedItem(){
            localStorage.setItem('searchedItem', this.searchItem);
            console.log(localStorage.getItem('searchedItem'));
        },

        gotoSearchPage(){
            this.$router.push('/search/'+this.searchItem);
        }
    }

}
</script>

<style lang="scss">
</style>
