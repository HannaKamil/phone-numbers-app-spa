<template>
    <div class="container">
        <h1>Phone Numbers</h1>

        <form>
            <select v-model="selectedCountry" @change="fetchPhoneNumbers">
                <option value="">Select country</option>
                <option v-for="country in countries" :key="country" :value="country">{{ country }}</option>
            </select>

            <select v-model="selectedState" @change="fetchPhoneNumbers">
                <option value="">Valid phone numbers</option>
                <option value="OK">Valid</option>
                <option value="NOK">Invalid</option>
            </select>
        </form>

        <table>
            <thead>
            <tr>
                <th>Country</th>
                <th>State</th>
                <th>Country Code</th>
                <th>Phone Number</th>
            </tr>
            </thead>
            <tbody>
            <tr v-for="phoneNumber in phoneNumbers.data" :key="phoneNumber.id">
                <td>{{ phoneNumber.country }}</td>
                <td>{{ phoneNumber.state }}</td>
                <td>{{ phoneNumber.country_code }}</td>
                <td>{{ phoneNumber.number }}</td>
            </tr>
            </tbody>
        </table>

        <div class="pagination">
            <button @click="prevPage" :disabled="!phoneNumbers.prev_page_url">Prev</button>
            <button @click="nextPage" :disabled="!phoneNumbers.next_page_url">Next</button>
        </div>
    </div>
</template>

<script>
export default {
    data() {
        return {
            phoneNumbers: {
                data: [],
                prev_page_url: null,
                next_page_url: null,
            },
            selectedCountry: '',
            selectedState: '',
            countries: [],
        };
    },
    methods: {
        fetchPhoneNumbers() {
            const url = '/api/phone-numbers';

            axios.get(url, {
                params: {
                    country: this.selectedCountry,
                    state: this.selectedState
                }
            }).then(response => {
                console.log('API Response:', response.data);
                this.phoneNumbers = {
                    data: response.data.data || [],
                    prev_page_url: response.data.prev_page_url || null,
                    next_page_url: response.data.next_page_url || null,
                };
            }).catch(error => {
                this.handleError(error);
            });
        },
        prevPage() {
            if (this.phoneNumbers.prev_page_url) {
                this.fetchPhoneNumbersFromUrl(this.phoneNumbers.prev_page_url);
            }
        },
        nextPage() {
            if (this.phoneNumbers.next_page_url) {
                this.fetchPhoneNumbersFromUrl(this.phoneNumbers.next_page_url);
            }
        },
        fetchPhoneNumbersFromUrl(url) {
            axios.get(url, {
                params: {
                    country: this.selectedCountry,
                    state: this.selectedState
                }
            }).then(response => {
                console.log('API Response:', response.data);
                this.phoneNumbers = {
                    data: response.data.data || [],
                    prev_page_url: response.data.prev_page_url || null,
                    next_page_url: response.data.next_page_url || null,
                };
            }).catch(error => {
                this.handleError(error);
            });
        },
        handleError(error) {
            if (error.response && typeof error.response === 'object') {
                const status = error.response.status;
                const message = error.response.data.message || 'Error fetching phone numbers.';
                alert(`Error: ${status} - ${message}`);
                console.error('Error details:', error.response);
            } else {
                alert('Error fetching phone numbers.');
                console.error('Error details:', error.message || error);
            }
        },
        fetchCountries() {
            axios.get('/api/countries')
                .then(response => {

                    console.log(this.countries);

                    this.countries = response.data;
                })
                .catch(error => {
                    this.handleError(error);
                });
        }
    },
    mounted() {
        this.fetchCountries();
        this.fetchPhoneNumbers();
    }
}
</script>
