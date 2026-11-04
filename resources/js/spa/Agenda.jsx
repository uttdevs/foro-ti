import { useState } from "react"
import { Link } from "react-router-dom"
import Img from "./Img"
import "./agenda.css"

/* DATOS */
const navegacion = [
  { titulo: "Temáticas", to: "/#tematicas", src: "/icono-ia.png", fallback: "🧠", variante: "cian" },
  { titulo: "Mapa del Evento", to: "/#mapa", src: "/icono-mapa.png", fallback: "📍", variante: "turquesa" },
  { titulo: "Agenda del Día", to: "/agenda", src: "/icono-agenda.png", fallback: "📅", variante: "violeta", activo: true },
]

const agendaJueves = [
  { hora: "08:00 - 09:00", actividad: "Registro y firma" },
  { hora: "09:00 - 09:30", actividad: "Inauguración" },
  {
    hora: "09:30 - 10:30",
    actividad: "Conferencia magistral",
    detalle: "Dr. Eduardo Berra Villaseñor",
    descripcion:
      "IoT Cognitivo: Integración de Inteligencia Artificial Generativa en Sistemas Embebidos Inteligentes",
  },
  { hora: "10:30 - 11:00", actividad: "Presentación de proyectos" },
  { hora: "11:00 - 11:30", actividad: "Break" },
  {
    hora: "11:30 - 13:00",
    actividad: "Mesas de trabajo simultáneas",
    ponentes: [
      "Dr. Eduardo Berra Villaseñor",
      "Mtro. Daniel Esau Villagran Cruz",
      "Ing. Julio César Rendón Corte",
      "Ing. Víctor Aldair Garmendia",
    ],
  },
  { hora: "13:00 - 14:00", actividad: "Comida" },
  { hora: "14:00 - 18:00", actividad: "Mesas de trabajo" },
]

const agendaViernes = [
  { hora: "09:00 - 10:00", actividad: "Inicio del evento" },
  {
    hora: "10:00 - 11:00",
    actividad: "Conferencia magistral",
    detalle: "Dr. Oliver García Ramírez",
    descripcion: "Evaluación del uso de Herramientas y Agentes de Inteligencia Artificial en la Educación",
  },
  { hora: "11:00 - 13:00", actividad: "Torneo de videojuegos", etiqueta: "FIFA · KOF · Street Fighter" },
  { hora: "13:00", actividad: "Premiación" },
]

/* COMPONENTES */
/* Una fila de la agenda (una actividad) */
function FilaAgenda({ fila }) {
  const [abierto, setAbierto] = useState(false)
  const esLarga = fila.descripcion && fila.descripcion.length > 120

  return (
    <li className="dia__fila">
      <p className="dia__hora">{fila.hora}</p>
      <div>
        <p className="dia__actividad">{fila.actividad}</p>
        {fila.detalle && <p className="dia__detalle">{fila.detalle}</p>}
        {fila.descripcion && (
          <>
            <p className={`dia__descripcion ${esLarga && !abierto ? "dia__descripcion--corta" : ""}`}>
              {fila.descripcion}
            </p>
            {esLarga && (
              <button
                type="button"
                className="dia__vermas"
                onClick={() => setAbierto(!abierto)}
                aria-expanded={abierto}
              >
                {abierto ? "Ver menos" : "Ver más"}
              </button>
            )}
          </>
        )}
        {fila.ponentes && (
          <ul className="dia__ponentes" aria-label="Ponentes">
            {fila.ponentes.map((nombre) => (
              <li key={nombre}>{nombre}</li>
            ))}
          </ul>
        )}
        {fila.etiqueta && <span className="dia__etiqueta">{fila.etiqueta}</span>}
      </div>
    </li>
  )
}

/* Una columna (un día) */
function DiaAgenda({ titulo, color, items, children }) {
  return (
    <div className={`dia dia--${color}`}>
      <span className="dia__pastilla">{titulo}</span>
      <ul className="dia__lista">
        {items.map((fila) => (
          <FilaAgenda key={fila.hora} fila={fila} />
        ))}
      </ul>
      {children}
    </div>
  )
}

/* PÁGINA */
function Agenda() {
  return (
    <main className="agenda-page">
      {/* Navegación superior */}
      <nav className="agenda-nav" aria-label="Secciones del foro">
        {navegacion.map((item) => (
          <Link
            key={item.titulo}
            to={item.to}
            className={`agenda-nav__item agenda-nav__item--${item.variante} ${item.activo ? "agenda-nav__item--activo" : ""}`}
            aria-current={item.activo ? "page" : undefined}
          >
            <span className="agenda-nav__icono">
              <Img src={item.src} alt="" fallback={item.fallback} fallbackClass="agenda-nav__emoji" />
            </span>
            <span>{item.titulo}</span>
          </Link>
        ))}
      </nav>

      {/* Panel de la agenda */}
      <section className="agenda-panel">
        <h1 className="agenda-panel__titulo">Agenda · ForoTI 2026</h1>
        <div className="agenda-dias">
          <DiaAgenda titulo="Jueves 26 de noviembre" color="cian" items={agendaJueves} />
          <DiaAgenda titulo="Viernes 27 de noviembre" color="fucsia" items={agendaViernes} />
        </div>
      </section>

      <Link to="/" className="agenda-volver">
        ← Volver al inicio
      </Link>
    </main>
  )
}

export default Agenda
