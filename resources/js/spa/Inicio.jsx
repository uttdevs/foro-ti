import { useEffect, useState } from "react"
import { Link, useLocation } from "react-router-dom"
import Img from "./Img"

/* Datos del evento */

const galeria = [
  { src: "/galeria-1.png", alt: "Joven programando", fallback: "💻", color: "from-indigo-950 to-purple-900" },
  { src: "/galeria-2.png", alt: "Dos personas jugando videojuegos", fallback: "🎮", color: "from-fuchsia-900 to-violet-800" },
  { src: "/galeria-3.png", alt: "Estudiante con laptop", fallback: "🤖", color: "from-blue-950 to-fuchsia-950" },
  { src: "/galeria-4.png", alt: "Comunidad tecnológica", fallback: "🧠", color: "from-purple-950 to-indigo-900" },
  { src: "/galeria-5.png", alt: "Torneo de videojuegos", fallback: "🏆", color: "from-cyan-950 to-violet-900" },
]

/* Los enlaces que empiezan con "/" cambian de página; los que empiezan con "#" bajan a una sección */
const informacion = [
  { title: "Temáticas", link: "#tematicas", src: "/icono-ia.png", fallback: "🧠", border: "border-cyan-400", glow: "shadow-[0_0_14px_#22d3ee66]" },
  { title: "Mapa del Evento", link: "#mapa", src: "/icono-mapa.png", fallback: "📍", border: "border-cyan-300", glow: "shadow-[0_0_14px_#67e8f966]" },
  { title: "Agenda del Evento", link: "/agenda", src: "/icono-agenda.png", fallback: "📅", border: "border-violet-400", glow: "shadow-[0_0_14px_#a78bfa66]" },
]

const tematicas = [
  { icon: "🤖", title: "Inteligencia artificial", description: "Conoce las posibilidades de la IA y su aplicación en diferentes ámbitos." },
  { icon: "📊", title: "Datos e innovación digital", description: "Explora cómo los datos impulsan nuevas ideas y soluciones tecnológicas." },
  { icon: "💻", title: "Desarrollo de software", description: "Descubre herramientas, técnicas y soluciones para crear aplicaciones." },
  { icon: "🎮", title: "Videojuegos y cultura digital", description: "Comparte tu interés por los videojuegos, la creatividad y las comunidades digitales." },
]

/* Forma con esquinas cortadas (panel del objetivo) */
const cortado =
  "[clip-path:polygon(3%_0,97%_0,100%_22%,100%_78%,97%_100%,3%_100%,0_78%,0_22%)]"
  const juegos = [

]

/* COMPONENTES PEQUEÑOS */

function Galeria() {
  const [actual, setActual] = useState(0)

  /* Avanza sola cada 4 segundos */
  useEffect(() => {
    const id = setInterval(() => {
      setActual((i) => (i + 1) % galeria.length)
    }, 4000)
    return () => clearInterval(id)
  }, [])

  return (
    <section className="mx-auto mt-8 max-w-4xl">
      <h2 className="mb-4 text-center text-xl font-extrabold sm:text-2xl">Galería del Evento</h2>

      <div className="overflow-hidden px-1 py-2">
        <div
          className="flex w-full transition-transform duration-500 ease-out"
          style={{ transform: `translateX(calc(20% - ${actual * 62}%))` }}
        >
          {galeria.map((foto, i) => (
            <div
              key={foto.src}
              className={`mr-[2%] flex aspect-[16/10] shrink-0 basis-[60%] items-center justify-center overflow-hidden rounded-xl border-2 bg-gradient-to-br ${foto.color} transition duration-500 ${
                i === actual
                  ? "scale-100 border-fuchsia-500 shadow-[0_0_16px_#d946ef88]"
                  : "scale-90 border-violet-500/50 opacity-60"
              }`}
            >
              <Img
                src={foto.src}
                alt={foto.alt}
                fallback={foto.fallback}
                className="h-full w-full object-cover"
                fallbackClass="text-6xl"
              />
            </div>
          ))}
        </div>
      </div>

      {/* Puntos de navegación */}
      <div className="mt-3 flex justify-center gap-2">
        {galeria.map((foto, i) => (
          <button
            key={foto.src}
            type="button"
            onClick={() => setActual(i)}
            aria-label={`Ver imagen ${i + 1}`}
            className={`h-2 rounded-full transition-all ${
              i === actual ? "w-6 bg-cyan-300" : "w-2 bg-slate-500"
            }`}
          />
        ))}
      </div>
    </section>
  )
}

function Registro() {
  const [nombre, setNombre] = useState("")
  const [correo, setCorreo] = useState("")
  const [enviado, setEnviado] = useState(false)

  const manejarEnvio = (e) => {
    e.preventDefault()
    console.log({ nombre, correo }) // Aquí se conectaría un servicio real (Google Forms, Formspree, etc.)
    setEnviado(true)
  }

  if (enviado) {
    return <p className="mt-6 font-bold text-cyan-300">¡Gracias, {nombre}! Tu registro fue recibido.</p>
  }

  const campo =
    "w-full rounded-lg border border-cyan-400/50 bg-[#0c2032] px-4 py-3 text-white outline-none focus:border-fuchsia-400"

  return (
    <form onSubmit={manejarEnvio} className="mx-auto mt-6 max-w-md space-y-4">
      <input type="text" required value={nombre} onChange={(e) => setNombre(e.target.value)} placeholder="Nombre completo" className={campo} />
      <input type="email" required value={correo} onChange={(e) => setCorreo(e.target.value)} placeholder="Correo electrónico" className={campo} />
      <button type="submit" className="w-full rounded-lg bg-cyan-400 px-6 py-3 font-black text-slate-950 transition hover:bg-fuchsia-400">
        Registrarme
      </button>
    </form>
  )
}

/* PÁGINA */

function Inicio() {
  const { hash } = useLocation()

  /* Al llegar desde otra página, baja hasta la sección del enlace (#mapa, #tematicas...) */
  useEffect(() => {
    if (hash) {
      document.querySelector(hash)?.scrollIntoView()
    } else {
      window.scrollTo(0, 0)
    }
  }, [hash])

  return (
    <main
      className="min-h-screen w-full overflow-x-hidden px-4 pb-6 text-white sm:px-6"
      style={{
        background:
          "radial-gradient(circle at 100% 0%, rgba(0,229,255,.35), transparent 32%), radial-gradient(circle at 0% 100%, rgba(217,70,239,.45), transparent 38%), #05060f",
      }}
    >

      
      {/* Encabezado */}
<header className="mx-auto flex w-full max-w-4xl items-center justify-between gap-3 px-3 py-4 sm:px-6">
  
  <a href="#inicio" className="w-[35%] shrink-0 sm:w-auto">
    <Img
      src="/logo-foroti.png"
      alt="Logo Foro TI 2026"
      fallback="FORO TI 2026"
      fallbackClass="text-2xl font-black text-cyan-300"
      className="h-12 w-full object-contain object-left sm:h-28 sm:w-auto"
    />
  </a>

  <div className="flex w-[60%] flex-row items-center justify-end gap-1 sm:w-auto sm:gap-6">
    {/* CAMBIO SOLO PARA PC: Subimos de sm:h-14 a sm:h-20 */}
    <Img
      src="/logo-ia.png"
      alt="Instituto de Investigación en Inteligencia Artificial"
      fallback="IIA"
      fallbackClass="text-sm font-bold text-slate-300"
      className="h-8 w-auto object-contain sm:h-20"
    />
    <Img
      src="/logo-segundo.png"
      alt="Ingeniería en Tecnologías de la Información e Innovación Digital"
      fallback="ITIID"
      fallbackClass="text-sm font-bold text-slate-300"
      className="h-8 w-auto object-contain sm:h-20"
    />
  </div>
</header>




      <section
        id="inicio"
        className="mx-auto mt-2 flex min-h-56 max-w-4xl flex-col items-center justify-center rounded-2xl border-2 border-cyan-300 px-5 py-10 text-center shadow-[0_0_24px_#22d3ee88] sm:min-h-72"
        style={{
          backgroundImage:
            "linear-gradient(rgba(5,6,15,.35), rgba(5,6,15,.35)), url('/fondo_foro_ti_2026.png'), linear-gradient(135deg,#071b42,#21105a,#061b40)",
          backgroundSize: "cover",
          backgroundPosition: "center",
        }}
      >
        <h1 className="text-4xl font-black tracking-wider sm:text-6xl">
          <span className="bg-gradient-to-r from-fuchsia-400 via-violet-400 to-cyan-300 bg-clip-text text-transparent">
            <Img
              src="/Group 4.png"
              fallbackClass="text-2xl font-black text-cyan-300"
              className="h-20 w-auto object-contain sm:h-28"
            />
          </span>
        </h1>

        <p className="mt-3 text-base font-semibold sm:text-xl">Datos, IA e Innovación Digital</p>

       <a
  href="/registro"
  className="mt-5 rounded-full bg-gradient-to-r from-sky-400 to-blue-500 px-6 py-2 text-xs font-bold uppercase tracking-wide shadow-lg transition hover:scale-105 sm:text-sm"
>
  Regístrate ahora
</a>
      </section>

      {/* Objetivo general */}
      <section className="mx-auto mt-6 max-w-4xl">
        <div className={`bg-gradient-to-r from-violet-500 via-cyan-300 to-violet-500 p-[2px] ${cortado}`}>
          <div className={`bg-[#101a26] px-6 py-5 text-center sm:px-12 sm:py-6 ${cortado}`}>
            <p className="text-lg font-extrabold text-white sm:text-xl">Objetivo General</p>
            <p className="mx-auto max-w-3xl text-xs leading-6 text-slate-200 sm:text-sm">
              Crear un espacio de participación e intercambio de conocimientos sobre tecnología, donde los usuarios
              puedan compartir ideas, experiencias, dudas y soluciones con las nuevas herramientas, tendencias e
              innovaciones tecnológicas, fomentando el aprendizaje colaborativo y el uso responsable de la tecnología.
            </p>
          </div>
        </div>
      </section>

      {/* Galería */}
      <Galeria />

      {/* Información */}
      <section className="mx-auto mt-6 max-w-4xl">
        <h2 className="mb-4 text-center text-xl font-extrabold sm:text-2xl">Información</h2>

        <div className="grid grid-cols-3 gap-3 sm:gap-5">
          {informacion.map((item) => {
            const esRuta = item.link.startsWith("/")
            const Enlace = esRuta ? Link : "a"
            const destino = esRuta ? { to: item.link } : { href: item.link }

            return (
              <Enlace
                key={item.title}
                {...destino}
                className={`group flex flex-col items-center rounded-xl border-2 bg-[#08121c]/90 px-2 py-3 text-center transition hover:-translate-y-1 sm:py-4 ${item.border} ${item.glow}`}
              >
                <h3 className="text-xs font-bold sm:text-base">{item.title}</h3>
                <div className="mt-3 flex h-16 w-16 items-center justify-center sm:h-24 sm:w-24">
                  <Img
                    src={item.src}
                    alt={item.title}
                    fallback={item.fallback}
                    className="h-full w-full object-contain transition group-hover:scale-110"
                    fallbackClass="text-5xl"
                  />
                </div>
              </Enlace>
            )
          })}
        </div>
      </section>

      {/* Torneo de videojuegos */}
<section className="relative mx-auto mt-6 max-w-4xl overflow-hidden rounded-2xl border-2 border-fuchsia-300 bg-gradient-to-r from-cyan-800 via-violet-700 to-fuchsia-600 p-3 shadow-[0_0_24px_#d946ef88] sm:p-4">
  <span aria-hidden="true" className="torneo__brillo" />

  <div className="relative flex flex-col items-center gap-3 sm:flex-row sm:gap-6">
    <Img
      src="/Duo.png"
      alt="FIFA x KOF"
      fallbackClass="text-5xl"
      className="torneo__logo h-16 w-auto shrink-0 object-contain drop-shadow-[0_0_14px_#fde047aa] sm:h-24"
    />

    <div className="flex-1 text-center">
      <span className="inline-block rounded-full bg-yellow-300 px-3 py-0.5 text-[10px] font-black uppercase tracking-wide text-slate-950 sm:text-xs">
        🏆 Premios por equipo
      </span>

      <h2 className="mt-1.5 text-xl font-black leading-tight sm:text-2xl">
        Torneo de videojuegos
      </h2>

      <div className="mt-2 flex flex-wrap items-center justify-center gap-2">
        {juegos.map((j) => (
          <div key={j.name} className="flex h-8 items-center rounded-lg bg-white/90 px-3 sm:h-9">
            <Img
              src={j.src}
              alt={j.name}
              fallback={j.name}
              fallbackClass="text-sm font-black italic text-slate-900"
              className="h-4 w-auto object-contain sm:h-5"
            />
          </div>
        ))}

        <a
          href="#registro"
          className="torneo__boton rounded-full bg-cyan-400 px-5 py-1.5 text-sm font-black text-slate-950 transition hover:scale-105 hover:bg-yellow-300"
        >
          ¡Ver Torneo!
        </a>
      </div>
    </div>
  </div>
</section>

      {/* Temáticas */}
      <section id="tematicas" className="mx-auto mt-12 max-w-4xl scroll-mt-6">
        <h2 className="mb-6 text-center text-2xl font-black text-cyan-300 sm:text-3xl">Temáticas del foro</h2>

        <div className="grid grid-cols-1 gap-4 sm:grid-cols-2">
          {tematicas.map((tema) => (
            <article
              key={tema.title}
              className="group rounded-2xl border border-cyan-400/50 bg-gradient-to-br from-[#102735] to-[#11102b] p-5 transition duration-300 hover:-translate-y-1"
            >
              <div className="flex h-14 w-14 items-center justify-center rounded-2xl bg-gradient-to-br from-cyan-400/20 to-fuchsia-500/20 text-3xl">
                {tema.icon}
              </div>
              <h3 className="mt-4 text-lg font-extrabold">{tema.title}</h3>
              <p className="mt-2 text-sm leading-6 text-slate-300">{tema.description}</p>
              <div className="mt-4 h-1 w-12 rounded-full bg-gradient-to-r from-cyan-400 to-fuchsia-500 transition-all duration-300 group-hover:w-full" />
            </article>
          ))}
        </div>
      </section>

      {/* Mapa */}
      <section id="mapa" className="mx-auto mt-12 max-w-4xl scroll-mt-6">
        <div className="overflow-hidden rounded-2xl border-2 border-cyan-400/60 bg-[#0c2032]/90">
          <div className="p-5 sm:p-7">
            <h2 className="text-2xl font-black text-cyan-300 sm:text-3xl">Mapa del evento</h2>
            <p className="mt-3 text-lg font-bold">Universidad Tecnológica de Tecamachalco</p>
            <p className="mt-1 text-sm leading-6 text-slate-300">
              Avenida Universidad Tecnológica 1, Barrio La Villita, C. P. 75483, Tecamachalco, Puebla.
            </p>

            <a
              href="https://www.google.com/maps/search/?api=1&query=Universidad+Tecnol%C3%B3gica+de+Tecamachalco+Puebla"
              target="_blank"
              rel="noopener noreferrer"
              className="mt-4 inline-flex items-center gap-2 rounded-full bg-cyan-400 px-5 py-2 font-bold text-slate-950 transition hover:bg-fuchsia-400"
            >
              📍 Cómo llegar <span aria-hidden="true">↗</span>
            </a>
          </div>

          <div className="px-4 pb-4 sm:px-6 sm:pb-6">
            <iframe
              title="Mapa de la Universidad Tecnológica de Tecamachalco"
              src="https://maps.google.com/maps?q=Universidad%20Tecnol%C3%B3gica%20de%20Tecamachalco%2C%20Puebla&z=15&output=embed"
              className="h-72 w-full rounded-xl border border-cyan-400/30 sm:h-96"
              loading="lazy"
              referrerPolicy="no-referrer-when-downgrade"
            />
          </div>
        </div>
      </section>

      {/* Registro (desactivado por ahora)
      <section id="registro" className="mx-auto mt-12 max-w-3xl scroll-mt-6 pb-10 text-center">
        <h2 className="text-2xl font-black text-cyan-300">¡Forma parte del Foro TI 2026!</h2>
        <p className="mt-3 text-slate-300">Descubre, aprende y comparte tus ideas con la comunidad tecnológica.</p>
        <Registro />
      </section>
      */}

      {/* Pie de página */}
      <footer className="mx-auto mt-12 max-w-4xl border-t border-cyan-500/40 py-6 text-center text-sm text-slate-400">
        <div className="flex flex-wrap items-center justify-center gap-6 sm:gap-10">
          <Img
            src="/logotiposep.png"
            alt="Logo SEP"
            fallback="SEP"
            fallbackClass="text-2xl font-black text-cyan-300"
            className="h-12 w-auto object-contain sm:h-16"
          />
          <Img
            src="/Logoamorapuebla.png"
            alt="Logo Por amor a Puebla, Pensar en grande"
            fallback="Amor a Puebla"
            fallbackClass="text-2xl font-black text-cyan-300"
            className="h-12 w-auto object-contain sm:h-16"
          />
          <Img
            src="/utt.png"
            alt="Universidad Tecnológica de Tecamachalco"
            fallback="UTT"
            fallbackClass="text-2xl font-black text-cyan-300"
            className="h-12 w-auto object-contain sm:h-28"
          />
        </div>
         <p className="mt-4">Tel: +52-249-422-3303 | Información: +52-222-537-8503 | <a href="https://www.facebook.com/share/1Gye3MG73h/" target="_blank" rel="noopener noreferrer" className="text-cyan-400 hover:text-fuchsia-400">Facebook: TI</a></p>
        <p className="mt-4">© 2026 Foro TI · Datos, IA e Innovación Digital</p>

        
      </footer>
    </main>
  )
}

export default Inicio