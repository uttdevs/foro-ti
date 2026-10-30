import { useState } from "react"

/* Muestra la imagen; si el archivo no existe, muestra un texto o emoji de respaldo */
function Img({ src, alt, className, fallback, fallbackClass = "text-5xl" }) {
  const [error, setError] = useState(false)

  if (error) {
    return (
      <span role="img" aria-label={alt} className={fallbackClass}>
        {fallback}
      </span>
    )
  }

  return <img src={src} alt={alt} className={className} onError={() => setError(true)} />
}

export default Img