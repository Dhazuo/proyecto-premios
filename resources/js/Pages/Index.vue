<template>
    <!--#header-->
    <div class="relative w-full h-full container py-12 mx-auto">
        <div class="container mx-auto text-center">
            <p class="text-6xl font-bold">Bienvenido</p>
        </div>
        <div class="flex overflow-x-hidden">
            <div class="transform form1 transition duration-700 mt-16 w-full translate-x-0">
                <div class="mx-auto w-4/5 lg:w-1/3 rounded-md bg-white border border-gray-200 shadow-lg p-4 ">
                    <div class="text-center font-bold">
                        <p>Regístrate</p>
                    </div>
                    <div v-if="errors.registered"
                         class="my-4 w-full rounded-md bg-red-300 border border-red-500 text-white p-2 flex text-center">
                        {{ errors.registered }}
                    </div>
                    <div class="mt-6 space-y-3 text-sm">
                        <div class="space-y-2 text-gray-400">
                            <label for="name">Nombre</label>
                            <div>
                                <input :class="errors.name != null ? 'border-red-500' : 'border-gray-300'" v-model="form.name" id="name" minlength="1" type="text"
                                       class="w-full rounded-md focus:outline-none border border-gray-300 shadow-sm py-1 px-2 focus:ring-0 focus:border-blue-500 transition duration-200">
                                <div v-if="errors.name"
                                     class="w-full text-red-500 p-2">
                                    {{ errors.name[0] }}
                                </div>
                            </div>
                        </div>
                        <div class="space-y-2 text-gray-400">
                            <label for="last_name">Apellido(s)</label>
                            <div>
                                <input :class="errors.last_name != null ? 'border-red-500' : 'border-gray-300'" v-model="form.last_name" id="last_name" minlength="1" type="text"
                                       class="w-full rounded-md focus:outline-none border border-gray-300 shadow-sm py-1 px-2 focus:ring-0 focus:border-blue-500 transition duration-200">
                                <div v-if="errors.last_name"
                                     class="w-full text-red-500 p-2">
                                    {{ errors.last_name[0] }}
                                </div>

                            </div>
                        </div>
                        <div class="space-y-2 text-gray-400">
                            <label for="email">Email</label>
                            <div>
                                <input :class="errors.email != null ? 'border-red-500' : 'border-gray-300'" v-model="form.email" id="email" minlength="1" type="email"
                                       class="w-full rounded-md focus:outline-none border border-gray-300 shadow-sm py-1 px-2 focus:ring-0 focus:border-blue-500 transition duration-200">
                                <div v-if="errors.email"
                                     class="w-full text-red-500 p-2">
                                    {{ errors.email[0] }}
                                </div>
                                <div class="w-full flex justify-end">
                                    <button @click.prevent="showLogin()"
                                            class="flex text-blue-500 my-1 text-sm text-right underline">¿Ya te
                                        registraste? Reclama tu premio.
                                    </button>
                                </div>
                            </div>
                        </div>
                        <div class="flex justify-center mt-6">
                            <button :disabled="isProcessing" @click.prevent="post"
                                    class="px-4 py-2 rounded-md shadow-md transition duration-200"
                                    :class="isProcessing ? 'bg-gray-300 text-gray-200' : 'text-white bg-blue-500 focus:bg-blue-600 hover:bg-blue-400'">
                                {{ isProcessing ? 'Procesando' : 'Registrar' }}
                            </button>
                        </div>
                    </div>
                </div>
            </div>
            <div class="transform form2 mt-16 w-full hidden transition duration-700 translate-x-full">
                <div class="mx-auto w-4/5 lg:w-1/3 rounded-md bg-white border border-gray-200 shadow-lg p-4">
                    <div class="text-center font-bold">
                        <label for="code">Ingresa tu código de participación</label>
                    </div>
                    <div class="my-4">
                        <div v-if="errors.no_result"
                             class="w-full rounded-md bg-red-300 border border-red-500 text-white p-2">
                            {{ errors.no_result }}
                        </div>
                    </div>
                    <div class="my-4">
                        <input v-model="participation_code" id="code" minlength="1" type="text"
                               :class="errors.participation_code != null ? 'border-red-500' : 'border-gray-300'"
                               class="w-full rounded-md focus:outline-none border border-gray-300 shadow-sm py-1 px-2 focus:ring-0 focus:border-blue-500 transition duration-200">
                        <div v-if="errors.participation_code"
                             class="w-full text-red-500 p-2 text-sm">
                            {{ errors.participation_code[0] }}
                        </div>
                        <div class="w-full flex justify-end">
                            <button @click.prevent="showLogin()"
                                    class="flex text-blue-500 my-1 text-sm text-right underline">¿Aún no estás
                                registrado? Registrate.
                            </button>
                        </div>
                    </div>
                    <div class="flex justify-center">
                        <button :disabled="isProcessing" @click.prevent="goToGift"
                                class="px-4 py-2 rounded-md shadow-md transition duration-200"
                                :class="isProcessing ? 'bg-gray-300 text-gray-200' : 'text-white bg-blue-500 focus:bg-blue-600 hover:bg-blue-400'">
                            {{ isProcessing ? 'Procesando' : 'Ir a tu regalo' }}
                        </button>

                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    name: "Index",
    computed: {
        user() {
            return this.$page.props.auth.user
        }
    },
    data() {
        return {
            form: {
                name: '',
                last_name: '',
                email: ''
            },
            isProcessing: false,
            errors: [],
            participation: '',
            login_form: false,
            participation_code: ''
        }
    },
    methods: {
        goToGift() {
            this.isProcessing = true
            axios.post(this.route('login_participant'), {
                participation_code: this.participation_code
            })
                .then(() => {
                    window.location = this.route('participation', this.participation_code)
                    this.isProcessing = false
                })
                .catch((err) => {
                    this.errors = err.response.data.errors
                    this.isProcessing = false
                })
        },
        showLogin() {
            if (this.login_form == false) {
                this.login_form = true

                let f1 = document.querySelector('.form1')
                let f2 = document.querySelector('.form2')

                setTimeout(() => f1.classList.replace('translate-x-0', '-translate-x-full'), 100)
                setTimeout(() => f1.classList.add('hidden'), 300)

                setTimeout(() => f2.classList.remove('hidden'), 400);
                setTimeout(() => f2.classList.replace('translate-x-full', 'translate-x-0'), 500)

            } else {
                this.login_form = false
                let f1 = document.querySelector('.form1')
                let f2 = document.querySelector('.form2')

                setTimeout(() => f2.classList.replace('translate-x-0', 'translate-x-full'), 100)
                setTimeout(() => f2.classList.add('hidden'), 300);

                setTimeout(() => f1.classList.remove('hidden'), 400)
                setTimeout(() => f1.classList.replace('-translate-x-full', 'translate-x-0'), 500)


            }
        },
        post() {
            this.isProcessing = true;
            axios.post(this.route('register'), this.form)
                .then((response) => {
                    //recibe el token de participación
                    this.participation = response.data.participation;
                })
                .then(() => {
                    //se redirige a la ruta dinamica mandando como parametro el token
                    window.location = this.route('participation', this.participation)
                    this.isProcessing = false
                })
                .catch((err) => {
                    this.errors = err.response.data.errors
                    this.isProcessing = false
                });
        }
    },
    watch:{
        "form.name": function (newVal, oldVal){
            if (this.errors.name && newVal != oldVal){
                this.errors.name = null
            }
        },
        "form.last_name": function (newVal, oldVal){
            if (this.errors.last_name && newVal != oldVal){
                this.errors.last_name = null
            }
        },
        "form.email": function (newVal, oldVal){
            if (this.errors.email && newVal != oldVal){
                this.errors.email = null
            }
        },
        participation_code: function (newVal, oldVal){
            if (this.errors.participation_code && newVal != oldVal){
                this.errors.participation_code = null
            }
        }
    }
}
</script>

<style scoped>

</style>
