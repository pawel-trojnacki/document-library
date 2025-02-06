import {Helmet} from "react-helmet-async";

type Props = {
  title?: string;
}

function Head({title}: Props) {
  return (
    <Helmet>
      <title>{title ? `${title} | Document Library` : "Document Library"}</title>
    </Helmet>
  );
}

export default Head;