import {Box, Button, Dialog, DialogContent, DialogTitle, TextField} from "@mui/material";
import {Controller, SubmitHandler, useForm} from "react-hook-form";
import {useMutation, useQueryClient} from "@tanstack/react-query";
import toast from "react-hot-toast";
import {CategoryPayload} from "../../common/types.ts";
import CategoryService from "../../service/CategoryService.ts";

type Props = {
  isOpen: boolean;
  onClose: () => void;
}

const defaultValues: CategoryPayload = {
  name: "",
}

function CategoryForm({isOpen, onClose}: Props) {
  const { control, handleSubmit, reset } = useForm<CategoryPayload>({defaultValues});
  const queryClient = useQueryClient();

  const {mutate, isPending} = useMutation({
    mutationFn: CategoryService.createCategory,
    onSuccess: () => {
      reset();
      queryClient.invalidateQueries({ queryKey: ['categories'] })
      onClose();
      toast.success("Category created");
    },
    onError: (error) => {
      toast.error(error.message);
    }
  });

  const onSubmit: SubmitHandler<CategoryPayload> = (data) => {
    mutate(data);
  }

  return (
    <Dialog
      open={isOpen}
      onClose={onClose}
      maxWidth="md"
    >
      <DialogTitle>Create category</DialogTitle>
      <DialogContent>
        <form onSubmit={handleSubmit(onSubmit)}>
          <Box sx={{ pb: 2, pt: 1 }}>
            <Controller
              name="name"
              control={control}
              rules={{
                required: "Category name is required"
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
                  label="Category name"
                  variant="outlined"
                  disabled={isPending}
                  required
                />
              )}
            />
          </Box>
          <Button
            variant="contained"
            type="submit"
            loading={isPending}
          >
            Save
          </Button>
        </form>
      </DialogContent>
    </Dialog>
  )
}

export default CategoryForm;