<template>
<div class="w3-container">
	<h1 class="w3-center">{{ months[month - 1].name }} {{ year }} Events</h1>

	<div class="w3-center w3-padding-16">
		<div class="w3-row-padding">
		  <div class="w3-third">
		  	<label class="w3-left">Event Name</label>
			<input class="w3-input w3-border" type="text" v-model="name" placeholder="Event Name" />
		  </div>
		  <div class="w3-third">
		    <label class="w3-left">Month</label>
			<select class="w3-select" v-model="month" @change="getCalendar">
				<option v-for="m in months" :key="m.id" :value="m.id">{{ m.name }}</option>
			</select>
		  </div>
		  <div class="w3-third">
		    <label class="w3-left">Year</label>
			<select class="w3-select" v-model="year" @change="getCalendar">
				<option v-for="yr in years" :key="yr" :value="yr">{{ yr }}</option>
			</select>
		  </div>
		</div>

		<div class="w3-row-padding">
		  <div class="w3-col checkbox-container">
		  	<input class="w3-check" type="checkbox" v-model="checkedDays" value="monday" />
			<label>Monday</label>
		  </div>
		  <div class="w3-col checkbox-container">
		  	<input class="w3-check" type="checkbox" v-model="checkedDays" value="tuesday" />
			<label>Tuesday</label>
		  </div>
		  <div class="w3-col checkbox-container">
		  	<input class="w3-check" type="checkbox" v-model="checkedDays" value="wednesday" />
			<label>Wednesday</label>
		  </div>
		  <div class="w3-col checkbox-container">
		  	<input class="w3-check" type="checkbox" v-model="checkedDays" value="thursday" />
			<label>Thursday</label>
		  </div>
		  <div class="w3-col checkbox-container">
		  	<input class="w3-check" type="checkbox" v-model="checkedDays" value="friday" />
			<label>Friday</label>
		  </div>
		  <div class="w3-col checkbox-container">
		  	<input class="w3-check" type="checkbox" v-model="checkedDays" value="saturday" />
			<label>Saturday</label>
		  </div>
		  <div class="w3-col checkbox-container">
		  	<input class="w3-check" type="checkbox" v-model="checkedDays" value="sunday" />
			<label>Sunday</label>
		  </div>
		</div>	
		
		<button class="w3-button w3-green w3-round w3-margin-top" :disabled="!name || !checkedDays.length" @click="save">
			Save
		</button>
	</div>
	<!--Calendar UI-->
	<div class="w3-container">
		<div v-if="isLoading" class="w3-center">
			<img src="loading.webp" class="w3-image" />
		</div>
		<ul v-else class="w3-ul w3-card-4"> 
			<li class="w3-bar" v-for="day in totalDays">
				<div class="w3-row" v-if="eventDates.includes(moment(year+'-'+month+'-'+day).format('YYYY-MM-DD'))">
					<div class="w3-col event-badge">
						<span class="w3-badge w3-xlarge w3-red">
							{{ day }} {{ moment(year+'-'+month+'-'+day).format("ddd") }}
						</span>
					</div>
					<div class="w3-rest w3-center">
						<div class="w3-panel w3-red w3-round-xxlarge">
							<p class="w3-large w3-serif">
								<i>
									{{ showEvent(moment(year+'-'+month+'-'+day).format('YYYY-MM-DD')) }}
								</i>
							</p>
						</div>
					</div>
				</div>
				<div v-else>
					<span class="w3-badge w3-xlarge w3-green">{{ day }}</span>
					<strong class="day">
						{{ moment(year+'-'+month+'-'+day).format("ddd") }}
					</strong>	  		
				</div>
			</li>
		</ul>
	</div>

	<div class="w3-modal" :style="{display: successModal}">
	    <div class="w3-modal-content">
			<header class="w3-container w3-green"> 
				<span @click="successModal=none" class="w3-button w3-display-topright">&times;</span>
				<h2>SUCCESS</h2>
			</header>
			<div class="w3-container w3-center">
				<p>Events saved successfully.</p>
			</div>
	        <footer class="w3-container w3-border-top w3-padding-16 w3-light-grey">
				<button @click="successModal=none" class="w3-button w3-green">Close</button>
    		</footer>
	    </div>
  	</div>

  	<div class="w3-modal" :style="{display: errorModal}">
	    <div class="w3-modal-content">
			<header class="w3-container w3-red"> 
				<span @click="errorModal=none" class="w3-button w3-display-topright">&times;</span>
				<h2>ERROR</h2>
			</header>
			<div class="w3-container w3-center">
				<p>
					Unable to save. For some reason, something went wrong.
				</p>
				<p v-for="error in errors" v-show="errors.length">{{ error }}</p>
			</div>
	      	<footer class="w3-container w3-border-top w3-padding-16 w3-light-grey">
				<button @click="errorModal=none" class="w3-button w3-red">Close</button>
    		</footer>
	    </div>
  	</div>
</div>
</template>
<script>
import moment from 'moment';

export default {
	data: () => ({
		moment: moment,
		name: '',
		month: '01',
		year: 2020,
		months: [
			{id: '01', name: 'January'},
			{id: '02', name: 'February'},
			{id: '03', name: 'March'},
			{id: '04', name: 'April'},
			{id: '05', name: 'May'},
			{id: '06', name: 'June'},
			{id: '07', name: 'July'},
			{id: '08', name: 'August'},	
			{id: '09', name: 'September'},	
			{id: '10', name: 'October'},	
			{id: '11', name: 'November'},	
			{id: '12', name: 'December'},	
		],
		years: [2020, 2021, 2022],
		checkedDays: [],
		totalDays: moment("2020-01").daysInMonth(),
		isLoading: false,
		eventDates: [],
		events: [],
		successModal: 'none',
		errorModal: 'none',
		errors: []
	}),
	mounted() {
    	console.log('Component mounted.');
    	this.getCalendar();
    },
	methods: {
		save(){
			this.isLoading = true;

            axios.post('/api/calendar-events', {
            	name: this.name,
                year: parseInt(this.year),
                month: parseInt(this.month),
                days: this.checkedDays
            }).then((res) => {
            	this.isLoading = false;
            	this.successModal = 'block';
            	this.events = res.data.data;
            	this.eventDates = res.data.data.map(event => event.event_date);
            }).catch(error => {
            	this.showErrors(error);
            });   
        },
        getCalendar(){
        	this.totalDays = moment(this.year+'-'+this.month).daysInMonth();
        	this.isLoading = true;
            
        	axios.get('/api/calendar-events?filter[month]='+parseInt(this.month)+'&filter[year]='+this.year)
        	.then((res) => {
            	this.isLoading = false;
            	this.events = res.data.data;
            	this.eventDates = res.data.data.map(event => event.event_date);
            }).catch(error => {
            	this.showErrors(error);
            });   	
        },
        showErrors(error){
    	    this.isLoading = false;
        	this.errorModal = 'block';
        	this.errors = [];
            this.errors.push(error);

            if (error.response.data.errors !== undefined) {
                Object.entries(
                    error.response.data.errors
                ).forEach(([key, value]) =>
                    this.errors.push(value.toString())
                );
            }
        },
        showEvent(eventDate){
        	var index = this.eventDates.indexOf(eventDate);

        	if (index !== -1) {
        		var name = this.events[index].name;
        		return name;
        	}
        }
	}
}
</script>
<style lang="css" scoped>
.checkbox-container {
	width: 14%;
}

.event-badge {
	width: 50px;
}

.day {
	text-transform: uppercase;
}
</style>