import {ChangeEvent, FormEvent, SyntheticEvent, useEffect, useMemo, useState} from "react";
import {useSearchParams} from "react-router";
import {useQuery} from "@tanstack/react-query";
import {Autocomplete, Box, Button, TextField} from "@mui/material";
import {Clear as ClearIcon, Search as SearchIcon} from "@mui/icons-material";
import CategoryService from "../../../service/CategoryService.ts";
import {Category} from "../../../common/types.ts";

function DocumentFilters() {
  const [searchParams, setSearchParams] = useSearchParams();
  const initialSearch = searchParams.get("search") ?? "";
  const initialCategoryId = searchParams.get("categoryId") ?? "";

  const categoriesQuery = useQuery({
    queryKey: ["categories"],
    queryFn: CategoryService.getCategories,
  });

  const [searchQuery, setSearchQuery] = useState(initialSearch);
  const [selectedCategory, setSelectedCategory] = useState<Category | null>(null);

  useEffect(() => {
    if (categoriesQuery.data?.items) {
      const matchedCategory = categoriesQuery.data.items.find(
        (cat) => cat.id === initialCategoryId
      );
      setSelectedCategory(matchedCategory || null);
    }
  }, [categoriesQuery.data, initialCategoryId]);

  const handleSearchChange = (e: ChangeEvent<HTMLInputElement>) => {
    setSearchQuery(e.target.value);
  }

  const handleCategoryChange = (_: SyntheticEvent, newValue: Category | null) => {
    setSelectedCategory(newValue);
  };

  const applyFilters = (e: FormEvent<HTMLFormElement>) => {
    e.preventDefault();
    setSearchParams({
      search: searchQuery,
      categoryId: selectedCategory ? selectedCategory.id : "",
    });
  }

  const resetFilters = (e: FormEvent<HTMLFormElement>) => {
    e.preventDefault();
    setSearchQuery("");
    setSelectedCategory(null);
    setSearchParams({search: "", categoryId: ""});
  }

  const categoryOptions = useMemo(
    () => categoriesQuery.data?.items ?? [],
    [categoriesQuery.data]
  );

  return (
    <form onSubmit={applyFilters} onReset={resetFilters}>
      <Box
        sx={{display: "flex", flexWrap: "wrap", gap: 2, mb: 3}}
      >
        <TextField
          name="search"
          label="Search documents"
          variant="outlined"
          size="small"
          sx={{ width: 240 }}
          value={searchQuery}
          onChange={handleSearchChange}
        />
        <Autocomplete
          disablePortal
          sx={{ width: 240 }}
          options={categoryOptions}
          getOptionLabel={(option) => option.name}
          value={selectedCategory}
          onChange={handleCategoryChange}
          renderInput={(params) => (
            <TextField {...params} size="small" label="Category" />
          )} />
        <Button
          variant="contained"
          size="small"
          type="submit"
          startIcon={<SearchIcon />}
        >
          Search
        </Button>
        <Button
          variant="outlined"
          size="small"
          type="reset"
          startIcon={<ClearIcon />}
        >
          Reset
        </Button>
      </Box>
    </form>
  )
}

export default DocumentFilters;