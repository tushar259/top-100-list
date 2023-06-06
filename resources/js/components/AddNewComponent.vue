<template>
    <div class="ad-content">
        <div class="form-group">
            <label for="input1">Headline / Title</label>
            <div class="headline-of-everything dropdown">
                <input v-model="selectedValue" class="form-control" @input="filterOptions" @focus="filterOptions" @blur="hideOptions" placeholder="Headline">
                <div class="dropdown-menu" v-if="showOptions">
                    <div v-for="option in filteredOptions" :key="option" class="dropdown-item" @click="selectOption(option)">{{ option.headline }}</div>
                </div>
            </div>
        </div>

        <div class="form-group">
            <label for="input2">Nav title</label>
            <!-- <input type="text" class="form-control" id="input2" placeholder="Navigation title" v-model="navTitle"> -->
            <div class="headline-of-everything dropdown">
                <input v-model="navTitle" class="form-control" @input="filterOptionsForNav" @focus="filterOptionsForNav" @blur="hideOptionsForNav" placeholder="Headline">
                <div class="dropdown-menu" v-if="showOptionsForNav">
                    <div v-for="option in filteredOptions" :key="option" class="dropdown-item" @click="selectOption(option)">{{ option.nav_headline }}</div>
                </div>
            </div>
        </div>

        <div class="form-group">
            <label for="input3">Priority</label>
            <input type="number" class="form-control" id="input3" placeholder="Navigation title" v-model="priority">
        </div>

        <div class="form-group text-center" v-if="uploadedHead == false">
            <button class="btn btn-success upload-button-in-ad-page" @click="uploadHeadClicked()" :disabled="isLoading">
                <span v-if="isLoading" class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
                    {{ isLoading ? 'Uploading...' : 'Upload' }}
            </button>
        </div>

        <div v-else>
            <div class="form-group text-center">
                <button class="btn btn-success upload-button-in-ad-page" @click="updateHeadClicked()" :disabled="isLoading">
                    <span v-if="isLoading" class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
                        {{ isLoading ? 'Updating...' : 'Update' }}
                </button>
                
                <button class="btn btn-secondary" style="margin-left: 10px;" @click="cancelHeadUpdate()" :disabled="isLoading">
                    <span v-if="isLoadingCancel" class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
                        {{ isLoadingCancel ? 'Canceling...' : 'Cancel' }}
                </button>
            </div>
            <hr class="my-4">
            <div style="height: 25px;background: linear-gradient(to right, rgb(190, 51, 51), rgb(50, 50, 167));cursor: pointer;border-radius: 4px;margin-bottom: 20px;text-align: center;color: white;" @click="hideValue = !hideValue">Show / Hide</div>
            <div :class="{'d-none': hideValue}">
                <div class="form-group box-of-content" v-for="(option, index) in currentNameandAmount" :key="index">
                    <div class="box-contents">
                        <div class="custom-column">    
                            <label for="input4">Name</label>
                            <input type="text" class="form-control" placeholder="Name" id="input4" v-model="option.name">
                        </div>
                        <div class="custom-column">
                            <label for="input5">Amount</label>
                            <input type="text" class="form-control" id="input5" placeholder="Amount" v-model="option.amount">
                        </div>
                        <button class="btn btn-danger delete-item-button" @click="deleteItem(option.id, index)">Delete</button>
                    </div>
                </div>
                <div>
                    <button class="btn btn-primary" @click="enterPressed()">Add new box</button> <button class="btn btn-success" style="margin-left: 10px;" @click="uploadAllNameandAmount()">Upload All Entry</button>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import { useToast } from 'vue-toastification';
const toast = useToast();

export default{
    
    data(){
        return{
            selectedValue: '',
            showOptions: false,
            showOptionsForNav: false,
            options: [],
            navOptions: [],
            previousOptions: [],
            filteredOptions: [],
            previousNameandAmount: [],
            currentNameandAmount: [],
            isLoading: false,
            isLoadingCancel: false,
            uploadedHead: false,
            navTitle: '',
            priority: null,
            selectedHeadline: false,
            selectedHeadlineId: '',
            newName: '',
            newAmount: '',
            hideValue: false,
        };
    },

    created(){
        this.getAllData();
    },

    computed: {
        
    },
    methods: {
        filterOptions() {
            const input = this.selectedValue.toLowerCase();
            this.filteredOptions = this.options.filter(option => option.headline.toLowerCase().includes(input));
            
            
            if(this.filteredOptions.length > 0){
                this.showOptions = true;
            }
            else{
                this.showOptions = false;
            }

            if(this.selectedValue == ""){
                this.showOptions = false;
            }
        },

        filterOptionsForNav() {
            const input = this.navTitle.toLowerCase();
            this.filteredOptions = this.options.filter(option => option.nav_headline.toLowerCase().includes(input));
            console.log(this.filteredOptions);
            
            if(this.filteredOptions.length > 0){
                this.showOptionsForNav = true;
            }
            else{
                this.showOptionsForNav = false;
            }

            if(this.navTitle == ""){
                this.showOptionsForNav = false;
            }
        },

        selectOption(option) {
            console.log(option);
            this.uploadedHead = true;
            this.selectedValue = option.headline;

            this.selectedHeadline = true;
            this.selectedHeadlineId = option.id;

            this.navTitle = option.nav_headline;
            this.priority = option.priority;

            if(option.lists_of_data == null){
                this.previousNameandAmount = [];
                this.currentNameandAmount = [];
                this.currentNameandAmount.push({
                    "id": "-100",
                    "name": "",
                    "amount": ""
                });
            }
            else{
                this.previousNameandAmount = [];
                this.currentNameandAmount = [];
                option.lists_of_data.forEach(item => {
                    this.previousNameandAmount.push(item);
                    this.currentNameandAmount.push(item);
                });
                
            }

            this.showOptions = false;
            this.showOptionsForNav = false;
        },

        hideOptions() {
            this.blurTimeout = setTimeout(() => {
                this.showOptions = false;
            }, 500); // Adjust the delay time as needed
        },

        hideOptionsForNav(){
            this.blurTimeout = setTimeout(() => {
                this.showOptionsForNav = false;
            }, 500); 
        },

        uploadHeadClicked(){
            this.isLoading = true;
            this.uploadedHead = false;
            if(this.selectedValue.trim() == "" || this.navTitle.trim() == "" || this.priority == "" || this.priority == null){
                if(this.selectedValue.trim() == ""){

                }
                if(this.navTitle.trim() == ""){

                }
                if(this.priority == "" || this.priority == null){

                }
            }
            else{
                
                const formData = new FormData();
                formData.append("title", this.selectedValue);
                formData.append("navTitle", this.navTitle);
                formData.append("priority", this.priority);
                axios.post('/api/upload-head', formData)
                .then(response =>{
                    console.log(response);
                    if(response.data.success == true){
                        toast.success("successfully uploaded! now insert values.");
                        this.uploadedHead = true;
                        this.selectedHeadline = true;
                        this.selectedHeadlineId = response.data.idOfTable;
                        this.currentNameandAmount.push({
                            "id": -100,
                            "name": "",
                            "amount": ""
                        });

                    }
                    this.isLoading = false;
                })
                .catch(error =>{
                    toast.error(error.response.data.message);
                    this.isLoading = false;

                });
            }
        },

        getAllData(){
            axios.get('/api/get-all-data-from-custom-all-tables')
            .then(response =>{
                console.log(response);
                if(response.data.success == true){
                    this.options = [];
                    this.previousOptions = [];
                    response.data.allData.forEach(item => {
                        this.options.push(item);
                        this.previousOptions.push(item);
                    });
                }
            })
            .catch(error =>{
                toast.error(error.response.data.message);
            })
        },

        enterPressed(){
            this.currentNameandAmount.push({
                "id": -100,
                "name": "",
                "amount": ""
            });
        },

        uploadAllNameandAmount(){
            if(this.selectedHeadlineId == "" || this.selectedHeadline == false){

            }
            else{
                const requestData = {
                    givenNameAndAmount: this.currentNameandAmount,
                    tableId: this.selectedHeadlineId
                };
                axios.post("/api/upload-all-name-and-amount", requestData)
                .then(response =>{
                    console.log(response);
                    if(response.data.success == true){
                        toast.success(response.data.message);
                        setTimeout(() => {
                            this.$router.go(0);
                        }, 500);
                    }
                    
                })
                .catch(error =>{
                    toast.error(error.response.data.message);
                });
            }
        },

        updateHeadClicked(){
            if(this.selectedHeadline == true){
                if(this.selectedValue.trim() == "" || this.navTitle.trim() == ""){
                    if(this.selectedValue.trim() == ""){
                        toast.error("Please select a Headline");
                    }
                    if(this.navTitle.trim() == ""){
                        toast.error("Please select a Nav title");
                    }
                }
                else{
                    const formData = new FormData();
                    formData.append("headId", this.selectedHeadlineId);
                    formData.append("headline", this.selectedValue.trim());
                    formData.append("navTitle", this.navTitle.trim());
                    formData.append("priority", this.priority);
                    axios.post("/api/update-headline-now", formData)
                    .then(response =>{
                        console.log(response);
                        if(response.data.success == true){
                            this.getAllData();
                            toast.success(response.data.message);
                        }
                        else{
                            toast.error(response.data.message);
                        }
                    })
                    .catch(error =>{
                        toast.error(error.response.data.message);
                    });
                }
            }
            else{
                toast.error("Please select an option!");
            }
        },

        cancelHeadUpdate(){
            this.selectedHeadline = false;
            this.selectedHeadlineId = '';
            this.previousNameandAmount = [];
            this.currentNameandAmount = [];
            this.navTitle = '';
            this.priority = null;
            this.uploadedHead = false;
            this.selectedValue = ''; // headline
        },

        deleteItem(id, index){
            const formData = new FormData();
            formData.append("itemId", id);
            formData.append("tableId", this.selectedHeadlineId);
            axios.post("/api/delete-specific-item", formData)
            .then(response =>{
                if(response.data.success == true){
                    this.currentNameandAmount.splice(index, 1);
                    toast.success(response.data.message);
                    this.getAllData();
                }
                else{
                    toast.error(response.data.message);
                }
            })
            .catch(error =>{
                toast.error(error.response.data.message);
            });
        }

    }
};
</script>

