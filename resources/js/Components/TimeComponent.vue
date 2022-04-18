<template>
    <div class="flex space-x-2 text-lg">
        <div class="flex space-x-1 ">
            <div class="rounded-md p-2 font-bold bg-white">
                {{ time.hour_digits.first ? time.hour_digits.first : '-' }}
            </div>
            <div class="rounded-md p-2 font-bold bg-white">
                {{ time.hour_digits.second ? time.hour_digits.second : '-' }}
            </div>
        </div>
        <div class="text-lg font-bold text-white flex items-center blink">:</div>
        <div class="flex space-x-1 ">
            <div class="rounded-md p-2 font-bold bg-white">
                {{ time.minutes_digits.first ? time.minutes_digits.first : '-' }}
            </div>
            <div class="rounded-md p-2 font-bold bg-white">
                {{ time.minutes_digits.second ? time.minutes_digits.second : '-' }}
            </div>
        </div>
    </div>
</template>

<script>
export default {
    name: "TimeComponent",
    data(){
        return{
            time: {
                hour_digits: {
                    first: null,
                    second: null
                },
                minutes_digits: {
                    first: null,
                    second: null
                },
            },
            interval: null,
            hours: [],
            minutes: []
        }
    },
    created() {
        this.interval = setInterval(() => {
            let date = new Date();

            if (date.getHours() < 10){
                this.hours[0] = '0'
                this.hours[1] = String(date.getHours())

                this.time.hour_digits.first = this.hours[0]
                this.time.hour_digits.second = this.hours[1]

            } else {
                let hours = String(date.getHours()).split('');

                this.time.hour_digits.first = hours[0]
                this.time.hour_digits.second = hours[1]

            }

            if (date.getMinutes() < 10){
                this.minutes[0] = '0'
                this.minutes[1] = String(date.getMinutes())

                this.time.minutes_digits.first = this.minutes[0]
                this.time.minutes_digits.second = this.minutes[1]
            } else {
                let minutes = String(date.getMinutes()).split('');

                this.time.minutes_digits.first = minutes[0]
                this.time.minutes_digits.second = minutes[1]
            }


        }, 1000)
    },
}
</script>

<style scoped>

</style>
