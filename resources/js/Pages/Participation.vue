<template>
    <div class="w-full h-full relative">
        <div class="h-14 bg-teal-500 shadow-lg w-full">
            <div class="flex h-full justify-center text-center items-center mx-auto text-white text-sm">
                <p> Tu participación es: <span class="font-bold underline">{{
                        participation_owner.participation ? participation_owner.participation : '-----'
                    }}</span></p>
            </div>
        </div>
        <div class="w-full h-full flex flex-col container mx-auto py-12 relative">
            <div v-if="participant_status == 'allowed'" class="mx-auto h-full relative">
                <div class="flex flex-col space-y-6 h-full relative">
                    <div class="space-y-2 text-center">
                        <p class="text-4xl font-bold">¡Felicidades!</p>
                        <p class="text-lg font-bold underline">Acabas de ganar {{ participant_award_prop ? 'un premio físico' : 'un código de regalo' }}</p>
                    </div>
                    <div class="h-80 bg-gray-300 rounded-md w-full flex justify-center items-center mx-auto">
                        <div class="space-y-2  text-center">
                            <p>ACA VA EL PREMIO XD</p>
                            <p class="text-lg font-bold">{{ participant_award_prop ? participant_award_prop : participant_code_prop }}</p>
                        </div>
                    </div>
                    <div class="font-bold text-center">
                        <p>Tu folio: {{ participant_tracking_prop }}</p>
                    </div>
                </div>
            </div>
            <div v-else class="space-y-8 mx-auto">
                <div v-if="errors.out_of_stock" class="my-8 rounded-md w-full text-lg p-2 text-center text-white bg-red-400 border border-red-500">
                    {{ errors.out_of_stock }}
                </div>
                <div v-else-if="message" class="my-8 rounded-md w-full text-lg p-2 text-center text-white bg-blue-400 border border-blue-500">
                    {{ message }}
                </div>
                <p class="font-bold text-2xl text-center">¿Quieres recibir el premio?</p>
                <div class="flex space-x-4 justify-center">
                    <button @click.prevent="awardParticipation($event)" id="yes" :disabled="isProcessing"
                            class="px-4 py-2 rounded-md shadow-md transition duration-200"
                            :class="isProcessing ? 'bg-gray-300 text-gray-200' : 'text-white bg-green-500 focus:bg-green-600 hover:bg-green-400'">
                        {{ isProcessing ? 'Procesando' : 'Sí' }}
                    </button>
                    <button @click.prevent="awardParticipation($event)" id="no" :disabled="isProcessing"
                            class="px-4 py-2 rounded-md shadow-md transition duration-200"
                            :class="isProcessing ? 'bg-gray-300 text-gray-200' : 'text-white bg-red-500 focus:bg-red-600 hover:bg-red-400'">
                        {{ isProcessing ? 'Procesando' : 'No' }}
                    </button>
                </div>
            </div>
            <div class="w-full flex justify-center mt-32">
                <inertia-link :href="route('index')" class="flex shadow-md rounded-md px-4 py-2 bg-teal-500 hover:bg-teal-400 transition duration-200 focus:bg-teal-600 text-white">Regresar al inicio</inertia-link>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    name: "Participation",
    props: {
        participation_owner: Object,
        participant_status_prop: String,
        participant_award: String,
        participant_code: String,
        participant_tracking: String
    },
    mounted() {
            console.log(this.participant_code_prop)
        },
    data() {
        return {
            isProcessing: false,
            user_response: '',
            participant_status: this.participant_status_prop,
            participant_award_prop: this.participant_award,
            participant_code_prop: this.participant_code,
            participant_tracking_prop: this.participant_tracking,
            errors: [],
            message: null
        }
    },
    methods: {
        awardParticipation(event) {
            let id = event.currentTarget.id;
            this.user_response = id
            this.isProcessing = true

            if (this.user_response == 'no' ) {
                axios.post(this.route('register_response'), {
                    response: this.user_response,
                    participation: this.participation_owner.participation
                })
                    .then((response) => {
                        this.message = response.data.message
                        this.isProcessing = false
                        if (this.errors.out_of_stock){
                            this.errors = []
                        }
                    })
            } else {
                axios.post(this.route('register_response'), {
                    response: this.user_response,
                    participation: this.participation_owner.participation
                })
                    .then((response) => {
                        if (response.data.code) {
                            this.participant_status = response.data.status
                            this.participant_code_prop = response.data.code
                            this.participant_tracking_prop = response.data.tracking
                            this.isProcessing = false
                        } else {
                            this.participant_status = response.data.status
                            this.participant_award_prop = response.data.award
                            this.participant_tracking_prop = response.data.tracking
                            this.isProcessing = false
                        }
                    })
                    .catch((err) => {
                        this.errors = err.response.data.errors
                        this.isProcessing = false
                    })
            }

        }
    }

}
</script>

<style scoped>

</style>
