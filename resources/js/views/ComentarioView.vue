<template>
    <div class="row">
        <div class="col-md-11 mx-auto">
            <div class="card">
                <div class="card-body">
                    <!-- Table -->
                    <ListarComentarioComponent />
                </div>
            </div>
        </div>
    </div>
</template>
<script>
import ListarComentarioComponent from '../components/comentario/ListarComentarioComponent';
export default {

    components: {
        ListarComentarioComponent ,
    },

}

</script>