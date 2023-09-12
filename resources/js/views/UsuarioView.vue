<template>
    <div class="row">
        <div class="col-md-11 mx-auto">
            <div class="card">
                <div class="card-body">
                    <!-- Table -->
                    <ListarUsuariosComponent />
                </div>
            </div>
        </div>
    </div>
</template>
<script>
import ListarUsuariosComponent from '../components/usuario/ListarUsuariosComponent';
export default {

components: {
    ListarUsuariosComponent,
},

}

</script>