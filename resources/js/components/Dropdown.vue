<template>
    <div class="dropdown relative">
        <div @click.prevent="isOpen = !isOpen"
            aria-haspopup="true"
            :aria-expanded="isOpen"
        >
            <slot name="trigger"></slot>
        </div>

       <div v-show="isOpen"
        class="dropdown-menu absolute bg-card py-2 rounded shadow mt-2" 
        :class="align === 'left' ? 'left-0': 'right-0'"
        :style="{width}">
           <slot></slot>
       </div>
    </div>
</template>

<script>
    export default {
        props:{
            align: {default: 'left'},
            width: {default: 'auto'}
        },

        data(){
            return {
                isOpen: false
            }
        },

        watch:{
            isOpen(isOpen){
                if(isOpen){
                    document.addEventListener('click', this.closeIfClickedOutside)
                }
            }
        },

        methods:{
            closeIfClickedOutside(){
                if(! event.target.closest('.dropdown')){
                    this.isOpen = false;

                    document.addEventListener('click', this.closeIfClickedOutside)
                }
            }
        }
    }
</script>