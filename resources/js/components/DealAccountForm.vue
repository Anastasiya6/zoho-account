<template>
    <div>
        <div class="form-group">
            <label for="dealName">Deal Name:</label>
            <input id="dealName" v-model="dealName" placeholder="Deal Name">
            <span v-if="!isValidString(dealName)" class="error-message">Deal Name is required</span>
        </div>

        <div class="form-group">
            <label for="dealStage">Deal Stage:</label>
            <input id="dealStage" v-model="dealStage" placeholder="Deal Stage">
            <span v-if="!isValidString(dealStage)" class="error-message">Deal Stage is required</span>
        </div>

        <div class="form-group">
            <label for="accountName">Account Name:</label>
            <input id="accountName" v-model="accountName" placeholder="Account Name">
            <span v-if="!isValidString(accountName)" class="error-message">Account Name is required</span>
        </div>

        <div class="form-group">
            <label for="accountWebsite">Account Website:</label>
            <input id="accountWebsite" v-model="accountWebsite" placeholder="Account Website">
            <span v-if="!isValidWebsite(accountWebsite)" class="error-message">Invalid Website</span>
        </div>

        <div class="form-group">
            <label for="accountPhone">Account Phone:</label>
            <input id="accountPhone" v-model="accountPhone" placeholder="Account Phone">
            <span v-if="!isValidPhone(accountPhone)" class="error-message">Invalid Phone</span>
        </div>

        <button @click="createDealAndAccount">Create Deal and Account</button>
        <div v-if="responseMessage">{{ responseMessage }}</div>
    </div>
</template>

<script>

    import axios from 'axios';

    export default {
        data() {
            return {
            dealName: '',
            dealStage: '',
            accountName: '',
            accountWebsite: '',
            accountPhone: '',
            responseMessage: '',
        };
    },
        methods: {

            async createDealAndAccount() {
                const isValid =
                    this.isValidString(this.dealName) &&
                    this.isValidString(this.dealStage) &&
                    this.isValidString(this.accountName) &&
                    this.isValidWebsite(this.accountWebsite) &&
                    this.isValidString(this.accountPhone);

                if (isValid) {
                    try {
                        const response = await axios.post('/api/create-deal-account', {
                            dealName: this.dealName,
                            dealStage: this.dealStage,
                            accountName: this.accountName,
                            accountWebsite: this.accountWebsite,
                            accountPhone: this.accountPhone
                        });
                        this.responseMessage = response.data.message;

                        /*this.dealName = '';
                        this.dealStage = '';
                        this.accountName ='';
                        this.accountWebsite = '';
                        this.accountPhone = '';*/
                    } catch (error) {
                        console.error('Error during API request:', error);
                    }
                } else {
                    console.error('Invalid data. Request not sent.');
                }
            },
            isValidString(value) {
                return typeof value === 'string' && value.trim() !== '';
            },
            isValidWebsite(website) {
                return /^(http|https):\/\/[^ "]+$/.test(website);
            },
            isValidPhone(phone) {
                const phoneRegex = /^[+]?[0-9]{1,4}[-.\s]?[(]?[0-9]{1,3}[)]?[-.\s]?[0-9]{1,4}[-.\s]?[0-9]{1,9}$/;
                return phoneRegex.test(phone);
            },
        }
    };

</script>
<style scoped>
.form-group {
    margin-bottom: 15px;
    display: flex;
    flex-direction: column;
}

.error-message {
    color: red;
    margin-top: 5px;
}
</style>
