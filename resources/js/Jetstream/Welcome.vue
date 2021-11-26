<template>
    <div class="flex flex-wrap bg-gray-300 ">
        <div class="mt-4 w-full lg:w-6/12 xl:w-3/12 px-5 mb-4">
            <div class="relative flex flex-col min-w-0 break-words bg-white rounded mb-3 xl:mb-0 shadow-lg">
                <div class="flex-auto p-4">
                <div class="flex flex-wrap">
                    <div class="relative w-full pr-4 max-w-full flex-grow flex-1">
                    <h5 class="text-blueGray-400 uppercase font-bold text-xs">SPP</h5>
                    <span class="font-semibold text-xl text-blueGray-700">{{payment?.spp}}</span>
                    </div>
                    <div class="relative w-auto pl-4 flex-initial">
                    <div class="text-white p-3 text-center inline-flex items-center justify-center w-12 h-12 shadow-lg rounded-full  bg-red-500">
                        <font-awesome-icon icon="user-secret" />
                    </div>
                    </div>
                </div>
                <p class="text-sm text-blueGray-400 mt-4">
                    <span class="text-red-500 mr-2"><i class="fas fa-arrow-down"></i> {{yearFilter}}</span>
                    <span class="whitespace-nowrap">  </span></p>
                </div>
            </div>
        </div>

        <div class=" mt-4 w-full lg:w-6/12 xl:w-3/12 px-5">
            <div class="relative flex flex-col min-w-0 break-words bg-white rounded mb-4 xl:mb-0 shadow-lg">
                <div class="flex-auto p-4">
                <div class="flex flex-wrap">
                    <div class="relative w-full pr-4 max-w-full flex-grow flex-1">
                    <h5 class="text-blueGray-400 uppercase font-bold text-xs">Daftar Ulang</h5>
                    <span class="font-semibold text-xl text-blueGray-700">{{payment?.daftar_ulang}}</span>
                    </div>
                    <div class="relative w-auto pl-4 flex-initial">
                    <div class="text-white p-3 text-center inline-flex items-center justify-center w-12 h-12 shadow-lg rounded-full  bg-pink-500">
                        <i class="fas fa-chart-pie"></i>
                    </div>
                    </div>
                </div>
                <p class="text-sm text-blueGray-400 mt-4">
                    <span class="text-red-500 mr-2"><i class="fas fa-arrow-down"></i> {{yearFilter}}</span>
                    <span class="whitespace-nowrap">  </span></p>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    import { defineComponent } from 'vue'
    import JetApplicationLogo from '@/Jetstream/ApplicationLogo.vue'
    import { library } from "@fortawesome/fontawesome-svg-core";
    import { faPhone, faUserSecret } from "@fortawesome/free-solid-svg-icons";
    import { FontAwesomeIcon } from '@fortawesome/vue-fontawesome'

    library.add(faUserSecret)

    export default defineComponent({
        components: {
            JetApplicationLogo,
            FontAwesomeIcon,
            faPhone,
            faUserSecret,
        },

        props: ['payment', 'yearFilter'],
        
    })
</script>
