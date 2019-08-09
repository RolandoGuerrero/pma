<template>
    <modal name="new-project" classes="p-10 bg-card rounded-lg" height="auto">
        <div class="text-normal mb-16 mt-4 text-center text-2xl w-full">Let's Start Something New!</div>
        <form @submit.prevent="submit">
            <div class="flex">
                <div class="flex-1 px-4">
                    <div class="mb-4">
                        <label for="title" class="text-sm block">Title</label>
                        <input type="text" class="input" :class="form.errors.title ? 'border-red-500' : ''" id="title" v-model="form.title">
                        
                       
                        <p class="text-red-500 text-xs italic" v-if="form.errors.title" v-text="form.errors.title[0]"></p>
                    </div>

                    <div class="mb-4">
                        <label for="description" class="text-sm block">Description</label>
                        <textarea 
                        type="text" 
                        class="input" 
                        id="description" 
                        rows="7" 
                        v-model="form.description"
                        :class="form.errors.description ? 'border-red-500' : ''">
                        </textarea>
                        <p class="text-red-500 text-xs italic" v-if="form.errors.description" v-text="form.errors.description[0]"></p>
                    </div>
                </div>
                <div class="flex-1 px-4">
                    <div class="mb-4">
                        <label class="text-sm block">Need Some Tasks?</label>
                        <input 
                        type="text" 
                        class="input mb-4" 
                        placeholder="Task" 
                        v-for="task in form.tasks"
                        v-model="task.body">
                    </div>

                    <button type="button" class="inline-flex items-center text-xs text-gray-500 mb-2" @click="addTask">
                        <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 18 18" class="mr-2">
                            <g fill="none" fill-rule="evenodd" opacity=".307">
                                <path stroke="#000" stroke-opacity=".012" stroke-width="0" d="M-3-3h24v24H-3z"></path>
                                <path fill="#000" d="M9 0a9 9 0 0 0-9 9c0 4.97 4.02 9 9 9A9 9 0 0 0 9 0zm0 16c-3.87 0-7-3.13-7-7s3.13-7 7-7 7 3.13 7 7-3.13 7-7 7zm1-11H8v3H5v2h3v3h2v-3h3V8h-3V5z"></path>
                            </g>
                        </svg>

                        <span class="text-default">Add New Task Field</span>
                    </button>
                </div>
            </div>

            <footer class="flex justify-end">
                <button  type ="button" class="button is-outlined mr-4" @click="$modal.hide('new-project')">Cancel</button>
                <button class="button">Create Project</button>
            </footer>
        </form>
    </modal>
</template>

<script>
    import PMAForm from './PMAForm';

    export default {
        data(){
            return{
                form: new PMAForm({
                    title: '',
                    description: '',
                    tasks : [
                        {body:''}
                    ]
                })
            }
        },
        methods:{
            addTask(){
                this.form.tasks.push({body:''});
            },
            submit(){
                this.form.submit('/projects')
                    .then(response => location = response.data.message);
            }
        }
    }
</script>
