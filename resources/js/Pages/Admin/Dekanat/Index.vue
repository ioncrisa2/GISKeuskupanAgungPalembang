<script setup>
import {ref} from "vue";
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import {Head,router,Link,useForm} from "@inertiajs/vue3";
import DataTable from 'primevue/datatable';
import Column from 'primevue/column';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import DangerButton from "@/Components/DangerButton.vue";
import Dialog from 'primevue/dialog';
import Button from 'primevue/button';
import InputText from 'primevue/inputtext';
import Toast from 'primevue/toast';
import ConfirmDialog from 'primevue/confirmdialog';
import { useToast } from 'primevue/usetoast';
import { useConfirm } from "primevue/useconfirm";

const props = defineProps({dekanat:Object});
const toast = useToast();
const confirm = useConfirm();

const visible = ref(false);
const editVisible = ref(false);
const editedItem = ref(null);

const namaInput = ref('');
const descInput = ref('');

const form = useForm({
    nama:null,
    desc:null
});

function saveData(){
    form.post(route('dekanat.store'),{
        onSuccess:() => {
            visible.value = false;
            form.reset();
            toast.add({ severity: 'contrast', summary: 'Berhasil', detail: 'Data Tersimpan', life: 3000 });
        },
        onError: () => {
            namaInput.value.focus();
            descInput.value.focus();
        }
    });
}

function openEditDialog(item){
    editedItem.value = item;
    form.nama = item.nama;
    form.desc = item.desc;
    editVisible.value = true;
}

function closeEditDialog(){
    editVisible.value = false;
    form.reset();
}

function updateData(){
    form.put(route('dekanat.update', editedItem.value.id),{
        onSuccess: () => {
            closeEditDialog();
            toast.add({ severity: 'contrast', summary: 'Berhasil', detail: 'Data Diperbarui', life: 3000 });
        },
    })
}

function deleteData(id){
    confirm.require({
        message: 'Do you want to delete this record?',
        header: 'Danger Zone',
        icon: 'pi pi-info-circle',
        rejectLabel: 'Cancel',
        acceptLabel: 'Delete',
        rejectClass: 'p-button-secondary p-button-outlined',
        acceptClass: 'p-button-danger',
        accept: () => {
            form.delete(route('dekanat.destroy',id),{
                onSuccess: () => toast.add({ severity: 'info', summary: 'Confirmed', detail: 'Record deleted', life: 3000 })
            })
        },
        reject: () => {
            toast.add({ severity: 'error', summary: 'Rejected', detail: 'You have rejected', life: 3000 });
        }
    });
}

</script>

<template lang="">
    <Head title="Data dekanat"/>
    <AuthenticatedLayout>
        <Toast/><ConfirmDialog/>
        <template #header>
            <div class="flex flex-row justify-between">
                <h2 class="font-semibold text-xl text-white leading-tight">
                    Tipe Data
                </h2>
                <div class="flex space-x-1">
                    <PrimaryButton class="ms-4 text-lg py-2 px-4" @click="visible = true">
                        Data Baru
                    </PrimaryButton>

                    <Dialog v-model:visible="visible" modal header="Buat Data Baru" :style="{ width: '25rem' }">
                        <div class="flex align-items-center gap-3 mb-3">
                            <InputText
                                id="nama"
                                ref="namaInput"
                                class="w-full"
                                autocomplete="off"
                                placeholder="Nama Dekanat"
                                v-model="form.nama"
                            />
                        </div>
                        <div class="flex align-items-center gap-3 mb-5">
                            <InputText
                                id="deskripsi"
                                ref="descInput"
                                class="w-full"
                                autocomplete="off"
                                placeholder="Deskripsi"
                                v-model="form.desc"
                            />
                        </div>
                        <div class="flex justify-end gap-2">
                            <Button type="button" label="Cancel" severity="secondary" @click="visible = false"></Button>
                            <Button type="button" label="Save" @click="saveData" severity="contrast"></Button>
                        </div>
                    </Dialog>
                </div>
            </div>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <DataTable :value="dekanat" tableStyle="min-width: 50rem">
                        <Column field="nama" header="Nama Dekanat"></Column>
                        <Column field="desc" header="Deskripsi"></Column>
                        <Column :exportable="false" style="min-width:8rem">
                            <template #body="slotProps">
                                <div class="flex space-x-2">
                                    <PrimaryButton @click="openEditDialog(slotProps.data)">edit</PrimaryButton>
                                    <DangerButton @click="deleteData(slotProps.data.id)">delete</DangerButton>

                                    <Dialog v-model:visible="editVisible" modal header="Edit Data" :style="{ width: '25rem' }">
                                        <div class="flex align-items-center gap-3 mb-3">
                                            <InputText
                                                id="nama"
                                                class="w-full"
                                                autocomplete="off"
                                                placeholder="Nama Dekanat"
                                                v-model="form.nama"
                                            />
                                        </div>
                                        <div class="flex align-items-center gap-3 mb-5">
                                            <InputText
                                                id="deskripsi"
                                                class="w-full"
                                                autocomplete="off"
                                                placeholder="Deskripsi"
                                                v-model="form.desc"
                                            />
                                        </div>
                                        <div class="flex justify-end gap-2">
                                            <Button type="button" label="Cancel" severity="secondary" @click="closeEditDialog"></Button>
                                            <Button type="button" label="Save" @click="updateData" severity="contrast"></Button>
                                        </div>
                                    </Dialog>
                                </div>
                            </template>
                        </Column>
                        <template #empty> <h1 class="text-center font-bold">Belum Ada Data!!</h1> </template>
                    </DataTable>
                </div>
            </div>
        </div>

    </AuthenticatedLayout>
</template>

