<template>
    
    <nav class="navbar navbar-expand-lg navbar-light" style="width: 100% !important">
        <!-- <a class="navbar-brand" href="#"> -->
        <img class="navbar-brand navbar-logo-custom" src="/logo/favicon2.png" alt="logo" @click="gotoHome()">
        <!-- </a> -->
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="navbar-collapse collapse" id="navbarNav">
            <ul class="navbar-nav">
                <li class="nav-item active">
                    <router-link class="nav-link" to="/"  >Home</router-link>
                </li>
                <li class="nav-item active">
                    <router-link class="nav-link" to="/"  >Home</router-link>
                </li>
                <li class="nav-item active">
                    <router-link class="nav-link" to="/"  >Home</router-link>
                </li>
                <li class="nav-item active">
                    <router-link class="nav-link" to="/"  >Home</router-link>
                </li>
                <li class="nav-item active">
                    <router-link class="nav-link" to="/"  >Home</router-link>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle text-truncate" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        Industry
                    </a>
                    <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                        <!-- <router-link class="dropdown-item" to="" :class="{ 'active': activeLink === 'hollywood' }" @click="collapse = true,activeLink = 'hollywood'">Hollywood</router-link>
                        <router-link class="dropdown-item" to="" :class="{ 'active': activeLink === 'football' }" @click="collapse = true,activeLink = 'football'">Football</router-link> -->
                        <!-- <a class="dropdown-item capitalized" v-for="(industryName, index) in allIndustry" :key="index" :class="{ 'active': activeLink === industryName.which_industry }" :href="'/polls/'+industryName.which_industry" @click="transferIndustryTo(industryName.which_industry)">{{industryName.which_industry}}</a> -->
                        
                        <!-- <div class="dropdown-divider"></div> -->
                    </div>
                </li>
                <li class="nav-item active">
                    <!-- <router-link class="nav-link" to="/countries" :class="{ 'active': activeLink === 'countries' }" @click="collapse = true,activeLink = 'countries'">Countries</router-link> -->
                </li>
                <!-- <li class="nav-item">
                    <router-link class="nav-link disabled" to="#">Disabled</router-link>
                </li> -->
            </ul>
            <hr class="my-1">
            <ul class="navbar-nav ml-auto"> <!-- d-none -->
                <li class="nav-item search-nav-item input-group">
                    <input class="form-control nav-search-input" placeholder="Search...">
                    <div class="input-group-append">
                        <button class="btn btn-outline-secondary" type="button" id="clearButton">
                            <i class="fas fa-times"></i>
                        </button>
                    </div>
                </li>
                <li class="nav-item">
                    <button class="btn btn-secondary nav-search-button">Search</button>
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
export default {
    name: 'App',
    

}
</script>

<style lang="scss">
</style>
