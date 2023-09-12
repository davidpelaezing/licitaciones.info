<template>
    <div>
        <div class="d-flex justify-content-between align-items-center mb-4">   
            <h3>Tags</h3>
            <button type="button" class="btn btn-success" @click="crear()">Crear tag</button>
        </div>
        
        <!-- Modal -->
        <div class="modal fade" ref="tagModal" id="tagModal" tabindex="-1" aria-labelledby="tagModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="tagModalLabel">{{ editando ? 'Editar': 'Crear' }} tag</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <FormTagComponent 
                            :data_editar="data_editar"
                            :editando="editando"
                            @submit="modal.hide(), editando = false, getTags()"
                            @cerrar="modal.hide(), editando = false"
                        />
                    </div>
                </div>
            </div>
        </div>

        <div class="table-responsive">
            <table class="table">
                <thead>
                    <th scope="col">id</th>
                    <th scope="col">nombre</th>
                    <th scope="col">estado</th>
                    <th scope="col">acciones</th>
                </thead>
                <tbody>
                    <tr v-for="tag in tags">
                        <th scope="row">{{ tag.id }}</th>
                        <td>{{ tag.nombre }}</td>
                        <td>{{ tag.estado ? 'Activo' : 'Inactivo' }}</td>
                        <td>
                            <div class="btn-group">
                                <button class="btn btn-sm btn-info" @click="editar(tag)">Editar</button>
                                <button class="btn btn-sm" @click="cambiarEstado(tag)" :class="tag.estado ? 'btn-danger' : 'btn-success'">{{ tag.estado ? 'Inactivar' : 'Activar' }}</button>
                            </div>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
    
</template>
<script>
import FormTagComponent from './FormTagComponent';
import { Modal } from 'bootstrap'
export default {
    components: {
        FormTagComponent
    },

    data(){
        return {
            tags: [],
            modal: null,
            editando: false,
            data_editar: null
        }
    },

    mounted(){
        this.modal = new Modal(this.$refs.tagModal)
        this.getTags();
    },

    methods: {

        async getTags(){
            try {
                const response = await this.axios.get('/tag')
                this.tags = response.data
            } catch (error) {
                console.log(error.response)
            }
        },

        async cambiarEstado(item){
            try {
                if(!confirm('Seguro que desea cambiar el estado de este item ' + item.nombre)){
                    return false;
                }
                const response = await this.axios.put('/tag/cambiar-estado/' + item.id);
                this.$toastr.success('¡El recurso se actualizo con exito!', '¡Exelente!')
                this.getTags();
            }catch (error) {
                console.log(error)
                console.log(error.response)
            }
        },  

        crear(){
            this.data_editar = null;
            this.editando = false;
            this.modal.show();
        },

        editar(item){
            this.data_editar = item;
            this.editando = true;
            this.modal.show();
        }

    }
}
</script>