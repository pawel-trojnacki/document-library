import {useEffect} from "react";
import {Box, Button, Dialog, DialogContent, DialogTitle, TextField} from "@mui/material";
import {MuiFileInput} from "mui-file-input";
import {AttachFile as AttachFileIcon} from "@mui/icons-material";
import {Controller, SubmitHandler, useForm} from "react-hook-form";
import {useMutation, useQueryClient} from "@tanstack/react-query";
import toast from "react-hot-toast";
import CategoryAutocomplete from "../common/CategoryAutocomplete.tsx";
import {DocumentPayload} from "../../common/types.ts";
import DocumentService from "../../service/DocumentService.ts";
import {useDocumentStore} from "../../store/documentStore.ts";

const defaultValues: DocumentPayload = {
  name: "",
  description: "",
  categoryId: null,
  file: null,
}

function DocumentForm() {
  const {document, isModalOpen, closeModal} = useDocumentStore();

  const { control, handleSubmit, reset } = useForm<DocumentPayload>({defaultValues});
  const queryClient = useQueryClient();

  useEffect(() => {
    if (document) {
      reset({
        name: document.name,
        description: document.description,
        categoryId: document.categoryId,
        file: null,
      });
    }
  }, [document, reset]);

  const createDocumentMutation = useMutation({
    mutationFn: DocumentService.createDocument,
    onSuccess: () => {
      reset();
      queryClient.invalidateQueries({ queryKey: ['documents'] })
      toast.success("Document created");
      closeModal();
    },
    onError: (error) => {
      toast.error(error.message);
    }
  });

  const editDocumentMutation = useMutation({
    mutationFn: DocumentService.editDocument,
    onSuccess: () => {
      reset();
      queryClient.invalidateQueries({ queryKey: ['documents'] })
      toast.success("Document updated");
      closeModal();
    },
    onError: (error) => {
      toast.error(error.message);
    }
  });

  const onSubmit: SubmitHandler<DocumentPayload> = (data) => {
    if (document) {
      editDocumentMutation.mutate({id: document.id, data});
    } else {
      const formData = new FormData();
      formData.append("name", data.name);
      formData.append("description", data.description);
      if (data.categoryId !== null) {
        formData.append("categoryId", data.categoryId);
      }
      if (data.file !== null) {
        formData.append("file", data.file);
      }

      createDocumentMutation.mutate(formData);
    }
  }

  return (
    <Dialog
      open={isModalOpen}
      onClose={closeModal}
      maxWidth="md"
    >
      <DialogTitle>{document ? "Edit document" : "Create document"}</DialogTitle>
      <DialogContent sx={{minWidth: "500px"}}>
        <form encType="multipart/form-data" onSubmit={handleSubmit(onSubmit)}>
          <Box sx={{ pb: 2, pt: 1 }}>
            <Controller
              name="name"
              control={control}
              rules={{
                required: "Name is required",
                minLength: {
                  value: 3,
                  message: "Name must be at least 3 characters long",
                },
              }}
              render={({field: { onChange, value }, fieldState: { error }}) => (
                <TextField
                  helperText={error ? error.message : null}
                  type="text"
                  size="small"
                  error={!!error}
                  onChange={onChange}
                  value={value}
                  fullWidth
                  label="Document name"
                  variant="outlined"
                  disabled={createDocumentMutation.isPending || editDocumentMutation.isPending}
                />
              )}
            />
          </Box>
          <Box sx={{ pb: 2, pt: 1 }}>
            <Controller
              name="description"
              control={control}
              render={({field: { onChange, value }, fieldState: { error }}) => (
                <TextField
                  helperText={error ? error.message : null}
                  type="text"
                  size="small"
                  error={!!error}
                  onChange={onChange}
                  value={value}
                  fullWidth
                  label="Description (optional)"
                  variant="outlined"
                  multiline
                  rows={3}
                  disabled={createDocumentMutation.isPending || editDocumentMutation.isPending}
                />
              )}
            />
          </Box>
          <Box sx={{ pb: 2 }}>
            <Controller
              name="categoryId"
              control={control}
              render={({ field }) => (
                <CategoryAutocomplete
                  value={field.value}
                  onChange={field.onChange}
                  label="Category (optional)"
                  disabled={createDocumentMutation.isPending || editDocumentMutation.isPending}
                />
              )}
            />
          </Box>
          {!document && (
            <Box sx={{ pb: 2 }}>
              <Controller
                name="file"
                control={control}
                rules={{
                  required: "File is requried"
                }}
                render={({field: { onChange, value }, fieldState: { error }}) => (
                  <MuiFileInput
                    helperText={error ? error.message : null}
                    size="small"
                    error={!!error}
                    onChange={onChange}
                    value={value}
                    fullWidth
                    label="Upload file"
                    variant="outlined"
                    disabled={createDocumentMutation.isPending || editDocumentMutation.isPending}
                    InputProps={{
                      inputProps: {
                        accept: '.xls,.xlsx,.doc,.docx,.pdf'
                      },
                      startAdornment: <AttachFileIcon />
                    }}
                  />
                )}
              />
            </Box>
          )}
          <Button
            variant="contained"
            type="submit"
            loading={createDocumentMutation.isPending || editDocumentMutation.isPending}
          >
            Save
          </Button>
        </form>
      </DialogContent>
    </Dialog>
  )
}

export default DocumentForm;