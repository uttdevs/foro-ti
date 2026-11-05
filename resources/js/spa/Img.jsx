import { useState } from "react"

/* Muestra la imagen; si el archivo no existe o no tiene src, muestra un texto o emoji de respaldo */
function Img({
  src,
  alt,
  className,
  fallback,
  fallbackClass = "text-5xl",
  loading = "lazy",
  decoding = "async",
  fetchPriority,
  ...rest
}) {
  const [error, setError] = useState(false)

  if (error || !src) {
    return (
      <span role="img" aria-label={alt} className={fallbackClass}>
        {fallback}
      </span>
    )
  }

  return (
    <img
      src={src}
      alt={alt}
      className={className}
      loading={loading}
      decoding={decoding}
      fetchPriority={fetchPriority}
      onError={() => setError(true)}
      {...rest}
    />
  )
}

export default Img
