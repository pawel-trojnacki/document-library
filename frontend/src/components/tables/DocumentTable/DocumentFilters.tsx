import { ChangeEvent, FormEvent, useState } from "react";
import { useSearchParams } from "react-router";
import { Box, Button, TextField } from "@mui/material";
import { Clear as ClearIcon, Search as SearchIcon } from "@mui/icons-material";
import CategoryAutocomplete from "../../common/CategoryAutocomplete.tsx";

function DocumentFilters() {
  const [searchParams, setSearchParams] = useSearchParams();
  const initialSearch = searchParams.get("search") ?? "";
  const initialCategoryId = searchParams.get("categoryId") ?? "";

  const [searchQuery, setSearchQuery] = useState(initialSearch);
  const [selectedCategoryId, setSelectedCategoryId] = useState<string | null>(initialCategoryId);

  const handleSearchChange = (e: ChangeEvent<HTMLInputElement>) => {
    setSearchQuery(e.target.value);
  };

  const applyFilters = (e: FormEvent<HTMLFormElement>) => {
    e.preventDefault();
    setSearchParams({
      search: searchQuery,
      categoryId: selectedCategoryId ?? "",
    });
  };

  const resetFilters = (e: FormEvent<HTMLFormElement>) => {
    e.preventDefault();
    setSearchQuery("");
    setSelectedCategoryId(null);
    setSearchParams({ search: "", categoryId: "" });
  };

  return (
    <form onSubmit={applyFilters} onReset={resetFilters}>
      <Box sx={{ display: "flex", flexWrap: "wrap", gap: 2, mb: 3 }}>
        <TextField
          name="search"
          label="Search documents"
          variant="outlined"
          size="small"
          sx={{ width: 240 }}
          value={searchQuery}
          onChange={handleSearchChange}
        />
        <CategoryAutocomplete
          value={selectedCategoryId}
          onChange={setSelectedCategoryId}
          width={240}
        />
        <Button variant="contained" size="small" type="submit" startIcon={<SearchIcon />}>
          Search
        </Button>
        <Button variant="outlined" size="small" type="reset" startIcon={<ClearIcon />}>
          Reset
        </Button>
      </Box>
    </form>
  );
}

export default DocumentFilters;
