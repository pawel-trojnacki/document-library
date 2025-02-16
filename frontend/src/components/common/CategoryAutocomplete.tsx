import {useMemo} from "react";
import {useQuery} from "@tanstack/react-query";
import {Autocomplete, TextField} from "@mui/material";
import CategoryService from "../../service/CategoryService.ts";

type Props = {
  value: string | null;
  onChange: (value: string | null) => void;
  label?: string;
  width?: string | number;
  disabled?: boolean;
};

function CategoryAutocomplete({value, onChange, label, width, disabled}: Props) {
  const {data, isLoading} = useQuery({
    queryKey: ["categories"],
    queryFn: CategoryService.getCategories,
  });

  const categoryOptions = useMemo(() => data?.items ?? [], [data]);

  return (
    <Autocomplete
      disablePortal
      options={categoryOptions}
      getOptionLabel={(option) => option.name}
      isOptionEqualToValue={(option, val) => option.id === val.id}
      value={categoryOptions.find((cat) => cat.id === value) || null}
      onChange={(_, newValue) => onChange(newValue ? newValue.id : null)}
      loading={isLoading}
      sx={{width: width ?? "100%"}}
      disabled={disabled ?? false}
      renderInput={(params) => (
        <TextField
          {...params}
          size="small"
          label={label ?? "Category"}
        />
      )}
    />
  );
}

export default CategoryAutocomplete;