const materialesLaptops = [
  "Alcohol Isopropílico con atomizador.",
  "Líquido limpiador de pantallas.",
  "Pasta térmica de su preferencia.",
  "Brochas para eliminar polvo.",
  "Paño de microfibra para pantallas.",
  "Kit de desarmadores de cruz y planos para abrir carcasas.",
  "Púa para guitarra o tarjeta plástica.",
  "Recipientes para organizar tornillos.",
  "Computadora para practicar el mantenimiento.",
]

export default function ModalMateriales({ abierto, alCerrar }) {
  if (!abierto) return null

  return (
    <div
      className="fixed inset-0 z-50 flex items-center justify-center bg-black/80 p-4 backdrop-blur-sm"
      onClick={alCerrar}
      role="dialog"
      aria-modal="true"
    >
      <div
        className="w-full max-w-lg rounded-2xl border-2 border-cyan-400/80 bg-gradient-to-br from-[#0c2032] via-[#0f172a] to-[#1e1035] p-5 sm:p-6 text-white shadow-[0_0_30px_rgba(34,211,238,0.35)] animate-in fade-in zoom-in-95 duration-200"
        onClick={(e) => e.stopPropagation()}
      >
        <div className="flex items-start justify-between border-b border-cyan-400/20 pb-3">
          <div className="flex items-center gap-2.5">
            <span className="text-2xl" aria-hidden="true">📦</span>
            <div>
              <h3 className="text-base sm:text-lg font-black text-cyan-300">
                Lista de materiales para taller
              </h3>
              <p className="text-xs text-slate-400">Mantenimiento y reparación de Laptops</p>
            </div>
          </div>
          <button
            type="button"
            onClick={alCerrar}
            className="rounded-lg p-1.5 text-slate-400 hover:bg-white/10 hover:text-white"
            aria-label="Cerrar modal"
          >
            ✕
          </button>
        </div>

        <p className="mt-4 text-xs sm:text-sm text-slate-300">
          Para llevar a cabo el taller, recomendar a los estudiantes traer la siguiente lista de materiales necesarios:
        </p>

        <ul className="mt-3.5 space-y-2 rounded-xl bg-slate-900/60 p-3.5 text-xs text-slate-200 border border-cyan-400/20">
          {materialesLaptops.map((m, idx) => (
            <li key={idx} className="flex items-start gap-2">
              <span className="text-cyan-400 font-bold">•</span>
              <span>{m}</span>
            </li>
          ))}
        </ul>

        <div className="mt-4 rounded-xl border border-amber-400/40 bg-amber-500/10 p-3 text-xs text-amber-200">
          <p className="font-bold flex items-center gap-1.5 text-amber-300">
            <span>⚠️</span> Nota importante:
          </p>
          <p className="mt-1 text-amber-200/90 leading-relaxed">
            El funcionamiento del equipo queda a responsabilidad del alumno.
          </p>
        </div>

        <div className="mt-5 text-right">
          <button
            type="button"
            onClick={alCerrar}
            className="w-full sm:w-auto rounded-lg bg-cyan-400 px-6 py-2.5 text-xs font-black text-slate-950 transition hover:bg-fuchsia-400"
          >
            Entendido
          </button>
        </div>
      </div>
    </div>
  )
}
