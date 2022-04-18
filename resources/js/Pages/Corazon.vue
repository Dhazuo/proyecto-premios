<template>
    <!--#header-->
    <div class="h-auto py-3 bg-lochmara-600 fixed w-full shadow-md flex items-center">
        <div class="w-full flex container mx-auto">
            <div class="flex space-x-0 md:space-x-4 ">
                <div></div>
                <div class="flex items-center">
                    <TimeComponent></TimeComponent>
                </div>
                <div class="hidden md:grid md:grid-cols-7 text-center text-white ">
                    <div class="px-2 border-r border-white flex items-center justify-center">
                        <p>INICIO</p>
                    </div>
                    <div class="px-2 border-r border-white flex items-center justify-center">
                        <p>CÓMO PARTICIPAR</p>
                    </div>
                    <div class="px-2 border-r border-white flex items-center justify-center">
                        <p>PREMIOS</p>
                    </div>
                    <div class="px-2 border-r border-white flex items-center justify-center">
                        <p>PRODUCTOS PARTICIPANTES</p>
                    </div>
                    <div class="px-2 border-r border-white flex items-center justify-center">
                        <p>VOTAR</p>
                    </div>
                    <div class="px-2 border-r border-white flex items-center justify-center">
                        <p>GANADORES</p>
                    </div>
                    <div class="px-2 flex items-center justify-center">
                        <p>CONTACTO</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import TimeComponent from "@/Components/TimeComponent";
export default {
    components: {TimeComponent},
    data(){
        return{
        }
    }
}
</script>

<style scoped>

</style>
