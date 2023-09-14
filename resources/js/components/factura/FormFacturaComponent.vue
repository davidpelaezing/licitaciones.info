<template>
    <form @submit.prevent="submit()">

        <div class="alert alert-warning" role="alert" v-if="!editando">
            para crear una factura primero debes generar una orden, basta con agregar productos al carrito y volver a este formulario.
        </div>

        <div class="alert alert-danger" role="alert" v-if="errores.length">
            <p v-for="error in errores">{{ error }}</p>
        </div>

        <select class="form-select mb-3" v-model="form.user_id" aria-label="Default select example" required>
            <option selected :value="null">Selecciona un usuario</option>
            <option v-for="usuario in usuarios" :value="usuario.id">{{ usuario.nombre }}</option>
        </select>

        <div class="mb-3">
            <label for="nombre" class="form-label">Nombre completo</label>
            <input type="text" class="form-control" v-model="form.nombre_completo" id="nombre" placeholder="Nombre ...">
        </div>
        <div class="mb-3">
            <label for="documento" class="form-label">Documento</label>
            <input type="number" class="form-control" v-model="form.documento" id="documento" placeholder="documento ...">
        </div>
        <div class="mb-3">
            <label for="tarjeta de credito" class="form-label">Tarjeta de credito</label>
            <input type="text" class="form-control" v-model="form.tarjeta_credito" id="tarjeta de credito" placeholder="tarjeta de credito ...">
        </div>
        <div class="mb-3">
            <label for="cvc" class="form-label">CVC</label>
            <input type="number" class="form-control" v-model="form.CVC" id="cvc" placeholder="cvc ...">
        </div>
        <div class="mb-3">
            <label for="fecha_vencimiento" class="form-label">Fecha vencimiendo de la tarjeta</label>
            <input type="date" class="form-control" v-model="form.fecha_vencimiento_tarjeta" id="fecha_vencimiento" placeholder="fecha_vencimiento ...">
        </div>

        <div class="btn-group">
            <button type="submit" class="btn btn-success">Finalizar</button>
            <button type="button" class="btn btn-danger" @click="$emit('cerrar')">Cancelar</button>
        </div>
    </form>
</template>
<script>

export default {

    props: {
        data_editar: {
            type: Object,
            default: null
        },
        editando: {
            type: Boolean,
            default: false,
        }
    },

    data(){
        return {
            usuarios: [],
            form: {
                user_id: null,
                nombre_completo: null,
                documento: null,
                tarjeta_credito: null,
                CVC: null,
                fecha_vencimiento_tarjeta: null
            },
            errores: [],
        }
    },

    mounted(){
        this.getUsuarios()
        this.editar() 
    },

    watch: {
        data_editar() {
            this.editar() 
        }
    },

    methods: {

        async submit(){
            try {
                if (this.editando){
                    await this.axios.put('/factura/actualizar/' + this.data_editar.id, this.form);
                    this.$snotify.success('¡El recurso se actualizo con exito!', '¡Exelente!')
                }else{
                    await this.axios.post('/factura/crear', this.form);
                    this.$snotify.success('¡El recurso se creo con exito!', '¡Exelente!')
                }
                this.limpiar()
                this.$emit('submit')
            } catch (error) {
                console.error(error.response);
                if(error.response.status === 422){
                    this.errores = Object.values(error.response.data).reduce((accumulator, currentArray) => {
                        return accumulator.concat(currentArray);
                    }, []);
                }
                if(error.response.status === 400){
                    this.errores = ['Debes de generar una Orden para poder crear la factura.']
                }
                this.$snotify.warning('¡Hay errores con la peticion!', '¡Error!')
            }
        },

        async getUsuarios(){
            try{
                const response = await this.axios.get('/user')
                this.usuarios = response.data
            }catch(error){
                this.$snotify.warning('¡Hay errores con la peticion!', '¡Error!')
            }
        },

        editar(){
            this.limpiar()
            if(this.editando){
                this.form.user_id = this.data_editar.user_id
                this.form.nombre_completo = this.data_editar.nombre_completo
                this.form.documento = this.data_editar.documento
                this.form.tarjeta_credito = this.data_editar.tarjeta_credito
                this.form.CVC = this.data_editar.CVC
                this.form.fecha_vencimiento_tarjeta = this.data_editar.fecha_vencimiento_tarjetaform
            }
            
        },

        limpiar(){
            this.form.user_id = null,
            this.form.nombre_completo = null,
            this.form.documento = null,
            this.form.tarjeta_credito = null,
            this.form.CVC = null,
            this.form.fecha_vencimiento_tarjeta = null
            this.errores = []
        }

    }

}

</script>