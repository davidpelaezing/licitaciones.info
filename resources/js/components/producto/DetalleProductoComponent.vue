<template>
    <div class="card" style="width: 100%;">
        <div class="card-body">
            <div class="row">

                <div class="col-md-4 col-sm-12">
                    <img :src="cargarlink(producto.imagen_url)" class="img-fluid" alt="Imagen del producto">
                </div>

                <div class="col-md-8 col-sm-12">
                    <h2 class="card-title">{{ producto.nombre }}</h2>
                    <h4 class="card-title">${{ producto.precio }}</h4>
                    <h5>categoria: <span class="badge bg-secondary">{{ producto.categoria.nombre}}</span></h5>
                    <span class="badge bg-primary" v-for="tag in producto.tags">{{ tag.nombre}}</span>
                    <p class="card-text">{{ producto.descripcion }}</p>
                    <form @submit.prevent="agregarAlCarro()">
                        <div class="input-group mb-3">
                            <input type="number" class="form-control" v-model="form.cantidad" placeholder="cantidad a agregar" aria-label="cantidad a agregar" aria-describedby="button-addon2">
                            <button class="btn btn-success" type="submit" id="button-addon2">Agregar</button>
                        </div>
                    </form>
                </div>

            </div>
        </div>
    </div>
</template>
<script>

export default {

    props: {
        producto:{
            type: Object
        }
    },

    data(){
        return {
            form: {
                cantidad: 1            
            }
        }
    },

    methods: {

        async agregarAlCarro(){
            try {
                const request = {
                    producto_id: this.producto.id,
                    cantidad: this.form.cantidad,
                }
                await this.axios.post('/orden/agregar-producto', request)
                this.limpiar()
                this.$router.push('/')
            }catch(error){
                if(error.response.status === 401){
                    this.$router.push('/login')
                }
            }
        },

        cargarlink(link){
            return link ? 'http://localhost:8000/storage/productos/' + link : 'https://picsum.photos/500/500'
        },

        limpiar(){
            this.form.cantidad = 1      
        }

    }

}

</script>