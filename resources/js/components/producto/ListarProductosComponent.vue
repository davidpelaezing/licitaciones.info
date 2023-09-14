<template>
    <div>
        <div class="d-flex justify-content-between align-items-center mb-4">   
            <h3>Productos</h3>
            <button type="button" class="btn btn-success" @click="crearProducto()">Crear producto</button>
        </div>
        
        <!-- Modal -->
        <div class="modal fade" ref="productoModal" id="productoModal" tabindex="-1" aria-labelledby="productoModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="productoModalLabel">{{ editando ? 'Editar': 'Crear' }} producto</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <FormProductoComponent 
                            :data_editar="data_editar"
                            :editando="editando"
                            @submit="modal.hide(), editando = false, getProductos()"
                            @cerrar="modal.hide(), editando = false"
                        />
                    </div>
                </div>
            </div>
        </div>

        <select class="form-select mb-3" v-model="filtro.categoria_id" aria-label="Default select example" @change="getProductos()">
            <option selected :value="null">Filtra por una categoria</option>
            <option v-for="categoria in categorias" :value="categoria.id">{{ categoria.nombre }} ({{ categoria.productos_count }})</option>
        </select>

        <div class="table-responsive">
            <table class="table">
                <thead>
                    <th scope="col">id</th>
                    <th scope="col">nombre</th>
                    <th scope="col">categoria</th>
                    <th scope="col">descripcion</th>
                    <th scope="col">#tags</th>
                    <th scope="col">precio</th>
                    <th scope="col">estado</th>
                    <th scope="col">acciones</th>
                </thead>
                <tbody>
                    <tr v-for="producto in productos">
                        <th scope="row"><img :src="cargarlink(producto.imagen_url)" width="25px" height="25px" class="rounded-circle" alt="Imagen del producto"></th>
                        <td>{{ producto.nombre }}</td>
                        <td>{{ producto.categoria.nombre }}</td>
                        <td>{{ producto.descripcion }}</td>
                        <td>{{ producto.tags_count }}</td>
                        <td>${{ producto.precio }}</td>
                        <td>{{ producto.estado ? 'Activo' : 'Inactivo' }}</td>
                        <td>
                            <div class="btn-group">
                                <button class="btn btn-sm btn-info" @click="editarProducto(producto)">Editar</button>
                                <button class="btn btn-sm" @click="cambiarEstado(producto)" :class="producto.estado ? 'btn-danger' : 'btn-success'">{{ producto.estado ? 'Inactivar' : 'Activar' }}</button>
                            </div>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>

        <pagination :data="paginacion" :limit="2" @pagination-change-page="getProductos"></pagination>

    </div>
    
</template>
<script>
import FormProductoComponent from './FormProductoComponent';
import { Modal } from 'bootstrap'
export default {
    components: {
        FormProductoComponent
    },

    data(){
        return {
            productos: [],
            categorias: [],
            paginacion: null,
            modal: null,
            editando: false,
            data_editar: null,
            filtro: {
                categoria_id: null
            },
        }
    },

    mounted(){
        this.modal = new Modal(this.$refs.productoModal)
        this.getProductos();
        this.getCategorias();
    },

    methods: {

        async getProductos(page = 1){
            try {
                const categoria = this.filtro.categoria_id ? this.filtro.categoria_id : '';
                const response = await this.axios.get('/producto?page=' + page + '&categoria_id=' + categoria)
                this.productos = response.data.data
                this.paginacion = response.data
            } catch (error) {
                console.log(error.response)
            }
        },

        async getCategorias() {
            try {
                const response = await this.axios.get('/categoria?activo=true');
                this.categorias = response.data;
            } catch (error) {
                console.log(error)
            }
        },

        async cambiarEstado(item){
            try {
                if(!confirm('Seguro que desea cambiar el estado de este item ' + item.nombre)){
                    return false;
                }
                const response = await this.axios.put('/producto/cambiar-estado/' + item.id);
                this.$toastr.success('¡El recurso se actualizo con exito!', '¡Exelente!')
                this.getProductos();
                console.log(response)
            }catch (error) {
                console.log(error)
                console.log(error.response)
            }
        },

        cargarlink(link){
            return link ? 'http://localhost:8000/storage/productos/' + link : 'https://picsum.photos/100/100'
        },

        crearProducto(){
            this.data_editar = null;
            this.editando = false;
            this.modal.show();
        },

        editarProducto(item){
            this.data_editar = item;
            this.editando = true;
            this.modal.show();
        }

    }
}
</script>