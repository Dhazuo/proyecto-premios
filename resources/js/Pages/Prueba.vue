<template>
    <div class="w-full h-full relative flex justify-center items-center">
        <div class="flex justify-center space-x-2">
            <div class="p-12 rounded-md bg-blue-500 text-white text-lg font-bold">
                {{ time.hour_digits.first ? time.hour_digits.first : '-' }}
            </div>
            <div class="p-12 rounded-md bg-blue-500 text-white text-lg font-bold">
                {{ time.hour_digits.second ? time.hour_digits.second : '-' }}
            </div>
            <div class="p-12 rounded-md bg-blue-500 text-white text-lg font-bold">
                {{ time.minutes_digits.first ? time.minutes_digits.first : '-' }}
            </div>
            <div class="p-12 rounded-md bg-blue-500 text-white text-lg font-bold">
                {{ time.minutes_digits.second ? time.minutes_digits.second : '-' }}
            </div>
        </div>
    </div>
</template>

<script>
export default {
name: "Prueba",
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
                seconds_digits: {
                    first: null,
                    second: null
                }
            },
            interval: null
        }
    },
    created() {
        this.interval = setInterval(() => {
            let date = new Date();
            let hours = String(date.getHours()).split('');
            let minutes = String(date.getMinutes()).split('');
            let seconds = String(date.getSeconds()).split('');

            this.time.hour_digits.first = hours[0]
            this.time.hour_digits.second = hours[1]

            this.time.minutes_digits.first = minutes[0]
            this.time.minutes_digits.second = minutes[1]

            this.time.seconds_digits.first = seconds[0]
            this.time.seconds_digits.second = seconds[1]
        }, 1000)
    },

}
</script>

<style scoped>

</style>
