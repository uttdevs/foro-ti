/* =========================================================
   TALLERES · Foro TI 2026
   Textos, maestros e imágenes se editan aquí.
   Los lugares disponibles vienen de la base de datos.
   ========================================================= */
import { useCallback, useEffect, useState } from "react"
import "./talleres.css"

// Tipos de etiqueta: hardware, datos, redes, ia, seguridad, sistemas, desarrollo

/* Maestros */
const MAESTROS = {
  josue: {
    nombre: "Ing. Josué Isaac Reyes Pérez",
    iniciales: "JI",
    empresa: "Grupo Salinas · Seguros Azteca",
    puesto: "Líder técnico en área de desarrollo",
  },
  uriel: {
    nombre: "Ing. José Uriel Rodríguez Ramírez",
    iniciales: "JU",
    empresa: "Softtek",
    puesto: "App Support Engineer Sr.",
  },
  antonio: {
    nombre: "Ing. Antonio Tobías Huerta",
    iniciales: "AT",
    empresa: "Sistemas Digitales de Vanguardia (Vía Digital)",
    puesto: "Líder de desarrollo y gestión del departamento de TI",
  },
  enrique: {
    nombre: "Ing. Enrique Peláez García",
    iniciales: "EP",
    empresa: "Santander México",
    puesto: "Developer Full Stack en el área de Biométricos",
  },
  victor: {
    nombre: "Ing. Víctor Aldair Garmendia",
    iniciales: "VG",
    empresa: "Datality",
    puesto: "CEO",
  },
  julio: {
    nombre: "Ing. Julio César Rendón Corte",
    iniciales: "JC",
    empresa: "Universidad de Los Ángeles",
    puesto: "Jefe de sistemas y comunicaciones",
  },
  edgar: {
    nombre: "Mtro. Edgar Bravo Romero",
    iniciales: "EB",
    empresa: "Universidad Tecnológica de Tecamachalco",
    puesto: "Profesor Asociado B",
  },
  daniel: {
    nombre: "Mtro. Daniel Esau Villagran Cruz",
    iniciales: "DE",
    empresa: "Sayux soluciones",
    puesto: "Technical Project Manager",
  },
}

/* Talleres
   "clave" debe ser igual a la clave de la tabla talleres en la base de datos. */
const talleres = [
  {
    clave: "analitica-predictiva",
    nombre: "Next-Gen Data: Analítica Predictiva y Machine Learning Cloud",
    categoria: "Datos", tipo: "datos", maestro: "daniel",
    imagen: "/img/analitica-predictiva.svg",
    descripcion: "Explora las últimas tendencias en analítica predictiva y machine learning en entornos cloud. Aprende a implementar soluciones avanzadas para el análisis de datos.",
  },
  {
    clave: "laptops",
    nombre: "Mantenimiento y reparación de Laptops",
    categoria: "Hardware", tipo: "hardware", maestro: "edgar",
    imagen: "/img/laptops.svg",
    descripcion: "Aprende a identificar fallas, realizar mantenimiento preventivo y reparar componentes de laptops. Practica técnicas de diagnóstico, limpieza y solución de problemas de hardware.",
  },
  {
    clave: "base-datos",
    nombre: "Bases de Datos en Entornos Empresariales",
    categoria: "Datos", tipo: "datos", maestro: "antonio",
    imagen: "/img/base-datos.svg",
    descripcion: "Diseña y administra bases de datos para empresas. Aprende a organizar información, realizar consultas SQL y gestionar datos de manera eficiente y segura.",
  },
  {
    clave: "nube-local",
    nombre: "Creación y Gestión de Nube Local",
    categoria: "Redes", tipo: "redes", maestro: "uriel",
    imagen: "/img/redes-cisco.svg",
    descripcion: "Crea y configura una nube local para almacenar, compartir y gestionar archivos entre dispositivos. Aprende a administrar usuarios, permisos y recursos sin depender de servicios externos.",
  },
  {
    clave: "chatbots",
    nombre: "Creación de Chatbots y asistentes virtuales",
    categoria: "IA", tipo: "ia", maestro: "enrique",
    imagen: "/img/chatbots.svg",
    descripcion: "Crea chatbots y asistentes virtuales capaces de responder preguntas y automatizar tareas. Aprende a diseñar conversaciones e integrar herramientas de inteligencia artificial.",
  },
  {
    clave: "spring-boot",
    nombre: "Creación de Microservicios Spring Boot",
    categoria: "Desarrollo", tipo: "desarrollo", maestro: "josue",
    imagen: "/img/python-seguro.svg",
    descripcion: "Desarrolla aplicaciones modulares con Spring Boot. Aprende a crear, configurar y conectar microservicios para construir sistemas eficientes y escalables.",
  },
  {
    clave: "mikrotik",
    nombre: "Despliegue de redes MikroTik con apoyo de IA",
    categoria: "Redes", tipo: "redes", maestro: "julio",
    imagen: "/img/subnetting.svg",
    descripcion: "Configura y despliega redes con equipos MikroTik utilizando herramientas de inteligencia artificial. Aprende a administrar routers, configurar conexiones y optimizar el rendimiento y la seguridad de la red.",
  },
  {
    clave: "ia",
    nombre: "Inteligencia Artificial (IA)",
    categoria: "Datos", tipo: "datos", maestro: "victor",
    imagen: "/img/datos-nube.svg",
    descripcion: "Explora las aplicaciones de la inteligencia artificial. Aprende a utilizar herramientas inteligentes para generar contenido, resolver problemas y automatizar tareas.",
  },
]

/* Estado según los lugares */
function estadoDe(lugares) {
  if (lugares <= 0) return { texto: "Agotado", clase: "agotado", agotado: true }
  if (lugares <= 3) return { texto: `Últimos ${lugares}`, clase: "ultimos", agotado: false }
  return { texto: `${lugares} lugares`, clase: "ok", agotado: false }
}

const csrf = () => document.querySelector('meta[name="csrf-token"]')?.content ?? ""

/* Título con resplandor fijo */
function Titulo() {
  return (
    <h1 className="talleres__h1">
      <span className="titulo-fx">
        <img className="titulo-fx__img" src="/img/titulo.png" alt="Seleccionar taller" />
        <img className="titulo-fx__glow" src="/img/titulo.png" alt="" aria-hidden="true" />
      </span>
    </h1>
  )
}

/* Una tarjeta */
function Tarjeta({ taller, lugares, ocupado, onInscribir }) {
  const cargando = lugares === undefined
  const e = estadoDe(lugares ?? 0)
  const agotado = !cargando && e.agotado
  const maestro = MAESTROS[taller.maestro]

  return (
    <article className={`taller ${agotado ? "taller--agotado" : ""}`}>
      <span className={`taller__tag taller__tag--${taller.tipo}`}>{taller.categoria}</span>
      <h3 className="taller__nombre">{taller.nombre}</h3>

      <div className="taller__maestro">
        <span className="taller__avatar" aria-hidden="true">{maestro.iniciales}</span>
        <div>
          <span className="taller__maestro-label">Maestro</span>
          <strong className="taller__maestro-nombre">{maestro.nombre}</strong>
          <span className="taller__maestro-puesto">{maestro.puesto}</span>
          <span className="taller__maestro-empresa">{maestro.empresa}</span>
        </div>
      </div>

      <p className="taller__descripcion">{taller.descripcion}</p>

      <div className="taller__media">
        <img src={taller.imagen} alt={`Ilustración del taller: ${taller.nombre}`} />
      </div>

      <div className="taller__lugares">
        <span>Lugares disponibles</span>
        <span className={`taller__estado taller__estado--${cargando ? "ok" : e.clase}`}>
          {cargando ? "Cargando…" : e.texto}
        </span>
      </div>

      <button
        className="taller__boton"
        type="button"
        disabled={cargando || agotado || ocupado}
        onClick={() => onInscribir(taller)}
      >
        {cargando ? "Cargando…" : agotado ? "Agotado" : ocupado ? "Inscribiendo…" : "Inscribirme"}
      </button>
    </article>
  )
}

/* Componente principal */
function Talleres() {
  const [datos, setDatos] = useState(null)   // { clave: { id, lugares } }
  const [aviso, setAviso] = useState(null)   // { texto, tipo }
  const [enviando, setEnviando] = useState(false)
  const [exito, setExito] = useState(null)   // { taller, lugares }

  const aplicar = useCallback((lista) => {
    const mapa = {}
    lista.forEach((t) => { mapa[t.clave] = { id: t.id, lugares: t.lugares } })
    setDatos(mapa)
  }, [])

  const cargar = useCallback(async () => {
    try {
      const r = await fetch("/talleres/datos", { headers: { Accept: "application/json" } })
      if (r.ok) aplicar(await r.json())
    } catch {
      /* sin conexión: se conserva lo último que se vio */
    }
  }, [aplicar])

  /* Trae los lugares y los refresca cada 20 segundos */
  useEffect(() => {
    if (exito) return
    cargar()
    const id = setInterval(cargar, 20000)
    return () => clearInterval(id)
  }, [exito, cargar])

  /* El aviso se oculta solo */
  useEffect(() => {
    if (!aviso) return
    const id = setTimeout(() => setAviso(null), 6000)
    return () => clearTimeout(id)
  }, [aviso])

  /* Al presionar "Inscribirme" */
  async function alInscribirse(taller) {
    const info = datos?.[taller.clave]
    if (!info || enviando) return

    if (!window.confirm(`¿Confirmas tu inscripción en "${taller.nombre}"?\nNo podrás cambiarla después.`)) return

    setEnviando(true)
    setAviso(null)

    try {
      const r = await fetch("/talleres/inscribir", {
        method: "POST",
        headers: {
          "Content-Type": "application/json",
          Accept: "application/json",
          "X-CSRF-TOKEN": csrf(),
        },
        body: JSON.stringify({ taller_id: info.id }),
      })
      const d = await r.json().catch(() => ({}))

      if (d.talleres) aplicar(d.talleres)

      if (r.ok) {
        setExito({ taller: d.taller, lugares: d.lugares })
        return
      }

      if (r.status === 419) {
        setAviso({ texto: "Tu sesión expiró. Vuelve a llenar el formulario.", tipo: "error" })
        setTimeout(() => { window.location.href = "/registro" }, 2500)
        return
      }

      setAviso({ texto: d.mensaje || "No se pudo completar la inscripción. Intenta de nuevo.", tipo: "error" })
      if (d.redirect) setTimeout(() => { window.location.href = d.redirect }, 2500)
    } catch {
      setAviso({ texto: "Sin conexión. Revisa tu internet e intenta de nuevo.", tipo: "error" })
    } finally {
      setEnviando(false)
    }
  }

  /* Pantalla final */
  if (exito) {
    return (
      <div id="talleres">
        <section className="exito">
          <h2 className="exito__titulo">¡Registro completado!</h2>
          <p>Quedaste inscrito en el taller:</p>
          <p className="exito__taller">{exito.taller}</p>
          <p className="exito__nota">Nos vemos en el Foro TI 2026.</p>
          <a className="taller__boton exito__boton" href="/">Volver al inicio</a>
        </section>
      </div>
    )
  }

  const pocos = datos
    ? talleres.filter((t) => datos[t.clave] && datos[t.clave].lugares > 0 && datos[t.clave].lugares <= 3)
    : []

  return (
    <>
      {aviso && <div className={`aviso aviso--${aviso.tipo}`} role="alert">{aviso.texto}</div>}

      <div id="titulo">
        <Titulo />
      </div>

      {pocos.length > 0 && (
        <p className="talleres__alerta">
          ⚠️ Quedan pocos lugares en {pocos.length} taller{pocos.length > 1 ? "es" : ""}. ¡Aparta el tuyo!
        </p>
      )}

      <div id="talleres">
        {talleres.map((taller) => (
          <Tarjeta
            key={taller.clave}
            taller={taller}
            lugares={datos?.[taller.clave]?.lugares}
            ocupado={enviando}
            onInscribir={alInscribirse}
          />
        ))}
      </div>
    </>
  )
}

export default Talleres