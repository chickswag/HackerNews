<template>
    <div class="card-body">


        <form id="taskAdd" action="#" @submit.prevent="createTask()">
                <div class="bg-info p-2">
                    Create New Task
                </div>
                <div class="form-group d-flex">
                    <input type="text" placeholder="name" name="name" class="form-control" required>
                    <input type="number" placeholder="priority" name="priority" class="form-control " required>
                    <input type="number" placeholder="Due In" name="dueIn" class="form-control " required>
                </div>
                <div>
                    <div class="d-flex ">
                        <button type="submit" title="SAVE ENTRY" class="btn btn-success flex-grow-1"><i class="fa fa-plus"></i></button>
                        <div class="btn btn-secondary flex-grow-1" title="CLEAR" @click="clearForm()"><i class="fa fa-refresh"></i></div>
                    </div>
                </div>


        </form>
        <h4 class="card-header mt-4" placeholder="Title" v-model="title"><i class="fa fa-list"></i> {{ title }}</h4>
        <hr/>
        <div class="mb-4 mt-4">
            <div class="btn btn-primary" title="TICK" @click="taskTick()"><i class="fa fa-check"></i></div>
        </div>

        <div v-if="tasks.length">
            <table class="table table-striped">
                <thead>
                <tr><td>#</td><td>Name</td><td>Priority</td><td>Due In</td><td>Action</td></tr>
                </thead>
                <tbody>

                <tr v-for="(task,index ) in tasks" :key="task.id">
                    <td>{{index+1}}</td>
                    <td>{{ task.name}}</td>
                    <td>{{ task.priority }}</td>
                    <td>{{ task.dueIn }}</td>
                    <td>
                        <div  @click="deleteTask(task.id)" class="btn btn-danger" title="DELETE" type="submit"><i class="fa fa-trash"></i></div>
                    </td>
                </tr>
                </tbody>

            </table>
<!--            <pagination :data="tasks">-->
<!--                <span slot="prev-nav">&lt; Previous</span>-->
<!--                <span slot="next-nav">Next &gt;</span>-->
<!--            </pagination>-->
        </div>


        <div v-else class="mb-4">
            No tasks yet<br/>
            <div  @click="createTask()" class="btn btn-primary" title="Create"><i class="fa fa-plus"></i></div>
        </div>


    </div>

</template>
<script>

    export default {

        data() {
            return {
                tasks: [],
                task:{
                    id: '',
                    name: '',
                    priority: 0,
                    dueIn: 0,
                },
                task_id: '',
                title : "Task List",
                edit:false,
                pagination:{},

            };
        },

        methods: {
            fetchTasks(page = 1) {
                axios.get('api/tasks?page=' + page).then((response) => {
                    this.tasks = response.data.handle_data;
                })

            },
            createTask() {
                var data = $('#taskAdd').serialize();
                axios.post('api/tasks', data)
                    .then((response) => {
                        console.log(response.data)
                        if(response.data.error)
                        {
                            $('.display-messages').html('<div class="alert alert-danger">'+response.data.message+'</div>');
                        }
                        else{
                            $('#taskAdd')[0].reset();
                            $('.display-messages').html('<div class="alert alert-success">'+response.data.message+'</div>');
                        }
                        setTimeout(function(){  $('.alert').fadeOut('slow'); }, 3000);
                    })
                    .catch((err) => console.error(err));
            },
            taskTick(){
                axios.get('api/list/tick')
                    .then((response) => {
                        this.fetchTasks();
                        $('.display-messages').html('<div class="alert alert-success">'+response.data.message+'</div>');
                        setTimeout(function(){  $('.alert').fadeOut('slow'); }, 3000);
                    })
                    .catch((err) => console.error(err));
            },
            clearForm(){
                $('#taskAdd')[0].reset();
            },
            // editTask(id){
            //     axios.get('api/task/'+id)
            //         .then((response) => {
            //             this.fetchTasks();
            //             $('.display-messages').html('<div class="alert alert-success">'+response.data.message+'</div>');
            //             setTimeout(function(){  $('.alert').fadeOut('slow'); }, 3000);
            //         })
            //         .catch((err) => console.error(err));
            // },

            deleteTask(id) {
                $.confirm({
                    theme: 'black',
                    animationBounce: 2.5,
                    closeIcon: true,
                    cancelButton:'Cancel',
                    icon: 'fa fa fa-trash fa-2x',
                    title:'Delete A Task!!!',
                    content: 'Are you sure you want to delete a task?',
                    type: 'red',
                    draggable: false,
                    buttons: {
                        tryAgain: {
                            text:  ' Delete',
                            btnClass: 'btn-blue fa fa-trash',
                            action: function(){
                                axios.get('api/deleteTask/'+id)
                                    .then((response) => {
                                        $('.display-messages').html('<div class="alert alert-success">'+response.data.message+'</div>');
                                        setTimeout(function(){  $('.alert').fadeOut('slow'); }, 3000);

                                    })
                                    .catch((err) => console.error(err));
                            }
                        },
                        cancel: function () {

                        }
                    }
                })
            },
        },
        updated() {
            this.fetchTasks();
        },
        mounted(){
            this.fetchTasks();
        },
    }
</script>

