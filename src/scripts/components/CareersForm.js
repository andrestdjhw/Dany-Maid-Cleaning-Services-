import React, { useRef, useState } from "react"
import Icon from "./Icon"
import { track } from "../analytics"

/*
 * Job application form, English / Spanish (toggle at the top). Option keys must match
 * dm_careers_options() in inc/careers.php; the server validates the same rules and answers
 * with field => code, and the message is shown here in the applicant's language.
 * GA4 events carry only form_id, language and position: no personal data.
 */

const T = {
  en: {
    title: "Job application",
    intro: "Fields marked optional can be left empty. Everything else helps us get to know you.",
    optional: "Optional",
    name: "Full name",
    phone: "Mobile phone",
    email: "Email",
    city: "City where you live",
    cityPlaceholder: "e.g. Citrus Heights",
    position: "Position you are interested in",
    schedule: "Schedule you are looking for",
    days: "Days you can work",
    experience: "House cleaning experience",
    transportation: "Do you have reliable transportation to get to work?",
    work_authorized: "Are you legally authorized to work in the United States?",
    languages: "Languages you speak",
    pets: "Are you comfortable working in homes with pets?",
    referral: "How did you hear about us?",
    about: "Tell us a little about yourself",
    aboutPlaceholder: "Previous jobs, what you enjoy about cleaning, when you could start…",
    choose: "Choose one…",
    consent: "I agree that Dany Maid may contact me by phone, text or email about my application.",
    submit: "Send My Application",
    sending: "Sending…",
    privacy: "We use your information only to review your application.",
    privacyLink: "Privacy Policy",
    successTitle: "Application received",
    successBody: "Thank you for your interest in joining Dany Maid. Our team will review your application and call you if your profile is a good fit.",
    reference: "Your reference:",
    questions: "Questions? Call us at",
    errorTitle: "We couldn’t send your application.",
    errorBody: "Your answers are still here. Please try again, or call us at",
    errors: {
      name: "Please enter your name.",
      phone: "Please enter a 10-digit phone number.",
      email: "Please enter a valid email address, or leave it empty.",
      city: "Please tell us the city where you live.",
      position: "Please choose a position.",
      schedule: "Please choose a schedule.",
      days: "Please choose at least one day.",
      experience: "Please choose your experience.",
      transportation: "Please answer this question.",
      work_authorized: "Please answer this question.",
      languages: "Please choose at least one language.",
      pets: "Please answer this question.",
      about: "Please keep this under 2,000 characters.",
      consent: "Please agree so we can contact you.",
      too_fast: "Please take a moment to review your answers and try again.",
      rate_limited: "Too many attempts. Please call us instead."
    },
    options: {
      position: { cleaner: "House cleaner", team_lead: "Team lead (with cleaning experience)", other: "Other / not sure" },
      schedule: { full: "Full-time", part: "Part-time", either: "Either" },
      days: { mon: "Mon", tue: "Tue", wed: "Wed", thu: "Thu", fri: "Fri", sat: "Sat", sun: "Sun" },
      experience: { none: "No experience, willing to learn", lt1: "Less than 1 year", "1to3": "1 to 3 years", "3plus": "More than 3 years" },
      languages: { en: "English", es: "Spanish", other: "Other" },
      yesno: { yes: "Yes", no: "No" },
      referral: { google: "Google", facebook: "Facebook / Instagram", friend: "A friend or family member", job_site: "Job website (Indeed, etc.)", other: "Other" }
    }
  },
  es: {
    title: "Solicitud de empleo",
    intro: "Los campos marcados como opcionales se pueden dejar vacíos. Lo demás nos ayuda a conocerte.",
    optional: "Opcional",
    name: "Nombre completo",
    phone: "Teléfono celular",
    email: "Correo electrónico",
    city: "Ciudad donde vives",
    cityPlaceholder: "p. ej. Citrus Heights",
    position: "Puesto que te interesa",
    schedule: "Horario que buscas",
    days: "Días que puedes trabajar",
    experience: "Experiencia en limpieza de casas",
    transportation: "¿Tienes transporte confiable para llegar al trabajo?",
    work_authorized: "¿Estás autorizado(a) legalmente para trabajar en los Estados Unidos?",
    languages: "Idiomas que hablas",
    pets: "¿Te sientes cómodo(a) trabajando en casas con mascotas?",
    referral: "¿Cómo supiste de nosotros?",
    about: "Cuéntanos un poco sobre ti",
    aboutPlaceholder: "Trabajos anteriores, qué te gusta de la limpieza, cuándo podrías empezar…",
    choose: "Elige una opción…",
    consent: "Acepto que Dany Maid me contacte por teléfono, mensaje de texto o correo sobre mi solicitud.",
    submit: "Enviar mi solicitud",
    sending: "Enviando…",
    privacy: "Usamos tu información solo para revisar tu solicitud.",
    privacyLink: "Política de privacidad",
    successTitle: "Solicitud recibida",
    successBody: "Gracias por tu interés en unirte a Dany Maid. Nuestro equipo revisará tu solicitud y te llamará si tu perfil es adecuado.",
    reference: "Tu número de referencia:",
    questions: "¿Preguntas? Llámanos al",
    errorTitle: "No pudimos enviar tu solicitud.",
    errorBody: "Tus respuestas siguen aquí. Inténtalo de nuevo o llámanos al",
    errors: {
      name: "Escribe tu nombre.",
      phone: "Escribe un número de teléfono de 10 dígitos.",
      email: "Escribe un correo válido o deja el campo vacío.",
      city: "Indica la ciudad donde vives.",
      position: "Elige un puesto.",
      schedule: "Elige un horario.",
      days: "Elige al menos un día.",
      experience: "Elige tu experiencia.",
      transportation: "Responde esta pregunta.",
      work_authorized: "Responde esta pregunta.",
      languages: "Elige al menos un idioma.",
      pets: "Responde esta pregunta.",
      about: "Escribe menos de 2,000 caracteres.",
      consent: "Acepta para que podamos contactarte.",
      too_fast: "Tómate un momento para revisar tus respuestas e inténtalo de nuevo.",
      rate_limited: "Demasiados intentos. Por favor llámanos."
    },
    options: {
      position: { cleaner: "Limpieza de casas", team_lead: "Líder de equipo (con experiencia en limpieza)", other: "Otro / no estoy seguro(a)" },
      schedule: { full: "Tiempo completo", part: "Medio tiempo", either: "Cualquiera" },
      days: { mon: "Lun", tue: "Mar", wed: "Mié", thu: "Jue", fri: "Vie", sat: "Sáb", sun: "Dom" },
      experience: { none: "Sin experiencia, con ganas de aprender", lt1: "Menos de 1 año", "1to3": "De 1 a 3 años", "3plus": "Más de 3 años" },
      languages: { en: "Inglés", es: "Español", other: "Otro" },
      yesno: { yes: "Sí", no: "No" },
      referral: { google: "Google", facebook: "Facebook / Instagram", friend: "Un amigo o familiar", job_site: "Sitio de empleos (Indeed, etc.)", other: "Otro" }
    }
  }
}

const EMPTY = {
  name: "", phone: "", email: "", city: "", position: "", schedule: "", days: [], experience: "",
  transportation: "", work_authorized: "", languages: [], pets: "", about: "", referral: "", consent: false, company: ""
}

const inputClass =
  "mt-2 block w-full rounded-xl border-0 bg-cream px-4 py-3 text-base text-ink ring-1 ring-brand-900/15 transition placeholder:text-ink/40 focus:bg-white focus:outline-none focus:ring-2 focus:ring-brand-600 aria-[invalid=true]:bg-red-50 aria-[invalid=true]:ring-red-500"
const chipClass =
  "flex min-h-12 items-center justify-center rounded-xl bg-cream px-3 py-2.5 text-center text-sm font-bold text-brand-900 ring-1 ring-brand-900/15 transition peer-checked:bg-brand-700 peer-checked:text-white peer-checked:ring-brand-700 peer-focus-visible:outline-2 peer-focus-visible:outline-offset-2 peer-focus-visible:outline-brand-700 hover:ring-brand-600"

// Same rules as dm_validate_application() in inc/careers.php.
function validate(v) {
  const e = {}
  if (v.name.trim().length < 2) e.name = true
  if (!/^1?\d{10}$/.test(v.phone.replace(/\D/g, ""))) e.phone = true
  if (v.email.trim() && !/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(v.email.trim())) e.email = true
  if (v.city.trim().length < 2) e.city = true
  ;["position", "schedule", "experience", "transportation", "work_authorized", "pets"].forEach(k => {
    if (!v[k]) e[k] = true
  })
  if (!v.days.length) e.days = true
  if (!v.languages.length) e.languages = true
  if (v.about.length > 2000) e.about = true
  if (!v.consent) e.consent = true
  return e
}

function initialLang() {
  const fromUrl = new URLSearchParams(window.location.search).get("lang")
  if (fromUrl === "es" || fromUrl === "en") return fromUrl
  try {
    const saved = localStorage.getItem("dm_careers_lang")
    if (saved === "es" || saved === "en") return saved
  } catch (err) {}
  return (navigator.language || "").toLowerCase().startsWith("es") ? "es" : "en"
}

function ErrorText({ id, children }) {
  return (
    <p id={id} className="mt-1.5 flex items-center gap-1.5 text-sm font-semibold text-red-700">
      <span aria-hidden="true">!</span> {children}
    </p>
  )
}

export default function CareersForm({ data, formId = "careers" }) {
  const { business, privacyUrl, careers } = data
  const [lang, setLang] = useState(initialLang)
  const [values, setValues] = useState(EMPTY)
  const [errors, setErrors] = useState({})
  const [status, setStatus] = useState("idle") // idle | submitting | success | error
  const [serverError, setServerError] = useState("")
  const [reference, setReference] = useState(null)
  const startedAt = useRef(Date.now())
  const started = useRef(false)
  const formRef = useRef(null)
  const t = T[lang]
  const p = "dm-job"

  function switchLang(next) {
    setLang(next)
    try {
      localStorage.setItem("dm_careers_lang", next)
    } catch (err) {}
  }

  function onFirstInteraction() {
    if (started.current) return
    started.current = true
    track("form_start", { form_id: formId, form_language: lang })
  }

  function update(name, value) {
    setValues(prev => ({ ...prev, [name]: value }))
    if (errors[name]) setErrors(prev => ({ ...prev, [name]: undefined }))
  }

  function toggle(name, key) {
    update(name, values[name].includes(key) ? values[name].filter(k => k !== key) : [...values[name], key])
  }

  const describedBy = name => (errors[name] ? `${p}-${name}-error` : undefined)

  function fieldProps(name) {
    return {
      id: `${p}-${name}`,
      name,
      value: values[name],
      onChange: e => update(name, e.target.value),
      onFocus: onFirstInteraction,
      "aria-invalid": errors[name] ? "true" : undefined,
      "aria-describedby": describedBy(name)
    }
  }

  function showErrors(found) {
    setErrors(found)
    Object.keys(found).forEach(field => track("form_error", { form_id: formId, field_type: field }))
    const first = Object.keys(found)[0]
    requestAnimationFrame(() => formRef.current?.querySelector(`[name="${first}"]`)?.focus())
  }

  async function onSubmit(e) {
    e.preventDefault()
    const found = validate(values)
    if (Object.keys(found).length) return showErrors(found)

    setStatus("submitting")
    setServerError("")
    try {
      const response = await fetch(careers.endpoint, {
        method: "POST",
        headers: { "Content-Type": "application/json" },
        body: JSON.stringify({ ...values, lang, elapsed: Date.now() - startedAt.current })
      })
      const body = await response.json().catch(() => ({}))

      if (response.ok && body.ok) {
        setReference(body.reference)
        setStatus("success")
        track("job_application_submit", { form_id: formId, form_language: lang, position: values.position })
        formRef.current?.closest("section")?.scrollIntoView({ behavior: "smooth", block: "start" })
        return
      }
      if (body.data?.fields) {
        setStatus("idle")
        return showErrors(body.data.fields)
      }
      setServerError(t.errors[body.message] || "")
      setStatus("error")
    } catch (err) {
      setStatus("error")
    }
  }

  const phoneLink = (
    <a href={business.phoneHref} data-location="careers_form" className="font-bold text-brand-700 underline">
      {business.phone}
    </a>
  )

  const langSwitch = (
    <div role="group" aria-label="Language / Idioma" className="inline-flex rounded-full bg-cream p-1 ring-1 ring-brand-900/10">
      {[
        ["en", "English"],
        ["es", "Español"]
      ].map(([code, label]) => (
        <button
          key={code}
          type="button"
          lang={code}
          aria-pressed={lang === code}
          onClick={() => switchLang(code)}
          className={`rounded-full px-4 py-2 text-sm font-bold transition focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-brand-700 ${lang === code ? "bg-brand-700 text-white shadow-sm" : "text-brand-900 hover:bg-white"}`}
        >
          {label}
        </button>
      ))}
    </div>
  )

  if (status === "success") {
    return (
      <div lang={lang} className="flex min-h-140 animate-fade-up flex-col items-center justify-center text-center" role="status">
        <span className="relative flex size-20 items-center justify-center">
          <span className="absolute inline-flex size-full animate-ping rounded-full bg-leaf-300 opacity-40" />
          <span className="relative flex size-20 items-center justify-center rounded-full bg-leaf-500 text-brand-950">
            <Icon name="check" className="size-10" />
          </span>
        </span>
        <h3 className="mt-8 font-display text-3xl font-semibold text-brand-950">{t.successTitle}</h3>
        <p className="mt-4 max-w-md text-lg leading-relaxed text-ink/75">{t.successBody}</p>
        {reference && (
          <p className="mt-6 rounded-full bg-cream px-5 py-2 text-sm font-semibold text-brand-900">
            {t.reference} <span className="font-extrabold">{reference}</span>
          </p>
        )}
        <p className="mt-8 text-sm text-ink/60">
          {t.questions} {phoneLink}
        </p>
      </div>
    )
  }

  function Label({ name, optional, children }) {
    return (
      <label htmlFor={`${p}-${name}`} className="flex items-baseline justify-between gap-3 text-sm font-bold text-brand-950">
        {children}
        {optional && <span className="shrink-0 text-xs font-semibold text-ink/50">{t.optional}</span>}
      </label>
    )
  }

  // Radio chips (single choice) or checkbox chips (multiple), as a labelled fieldset.
  function Choices({ name, legend, options, multiple, cols }) {
    return (
      <fieldset aria-describedby={describedBy(name)} aria-invalid={errors[name] ? "true" : undefined}>
        <legend className="text-sm font-bold text-brand-950">{legend}</legend>
        <div className={`mt-2 grid gap-2 ${cols}`}>
          {Object.entries(options).map(([key, label], i) => (
            <label key={key} className="cursor-pointer">
              <input
                type={multiple ? "checkbox" : "radio"}
                name={name}
                value={key}
                checked={multiple ? values[name].includes(key) : values[name] === key}
                onChange={() => (multiple ? toggle(name, key) : update(name, key))}
                onFocus={onFirstInteraction}
                id={i === 0 ? `${p}-${name}` : undefined}
                className="peer sr-only"
              />
              <span className={chipClass}>{label}</span>
            </label>
          ))}
        </div>
        {errors[name] && <ErrorText id={`${p}-${name}-error`}>{t.errors[name]}</ErrorText>}
      </fieldset>
    )
  }

  function Select({ name, label, options, optional }) {
    return (
      <div>
        <Label name={name} optional={optional}>
          {label}
        </Label>
        <div className="relative">
          <select className={`${inputClass} appearance-none pr-12`} {...fieldProps(name)}>
            <option value="">{t.choose}</option>
            {Object.entries(options).map(([key, text]) => (
              <option key={key} value={key}>
                {text}
              </option>
            ))}
          </select>
          <Icon name="chevron-down" className="pointer-events-none absolute right-4 top-1/2 size-5 -translate-y-1/2 text-brand-700" />
        </div>
        {errors[name] && <ErrorText id={`${p}-${name}-error`}>{t.errors[name]}</ErrorText>}
      </div>
    )
  }

  function Text({ name, label, type = "text", optional, ...rest }) {
    return (
      <div>
        <Label name={name} optional={optional}>
          {label}
        </Label>
        <input type={type} className={inputClass} {...fieldProps(name)} {...rest} />
        {errors[name] && <ErrorText id={`${p}-${name}-error`}>{t.errors[name]}</ErrorText>}
      </div>
    )
  }

  const submitting = status === "submitting"
  const o = t.options

  return (
    <form ref={formRef} lang={lang} onSubmit={onSubmit} noValidate aria-labelledby={`${p}-title`} className="space-y-6">
      <div className="flex flex-col-reverse gap-4 sm:flex-row sm:items-start sm:justify-between">
        <div>
          <h3 id={`${p}-title`} className="font-display text-2xl font-semibold text-brand-950">
            {t.title}
          </h3>
          <p className="mt-1 text-sm text-ink/60">{t.intro}</p>
        </div>
        <div className="shrink-0">{langSwitch}</div>
      </div>

      {status === "error" && (
        <div role="alert" className="animate-slide-down rounded-2xl bg-red-50 p-4 text-sm text-red-800 ring-1 ring-red-200">
          <p className="font-bold">{serverError || t.errorTitle}</p>
          <p className="mt-1">
            {t.errorBody} {phoneLink}.
          </p>
        </div>
      )}

      <div className="grid gap-5 sm:grid-cols-2">
        {Text({ name: "name", label: t.name, autoComplete: "name" })}
        {Text({ name: "phone", label: t.phone, type: "tel", autoComplete: "tel", inputMode: "tel", placeholder: "(916) 555-0123" })}
        {Text({ name: "email", label: t.email, type: "email", optional: true, autoComplete: "email", inputMode: "email" })}
        {Text({ name: "city", label: t.city, autoComplete: "address-level2", placeholder: t.cityPlaceholder })}
        {Select({ name: "position", label: t.position, options: o.position })}
        {Select({ name: "experience", label: t.experience, options: o.experience })}
      </div>

      {Choices({ name: "schedule", legend: t.schedule, options: o.schedule, cols: "grid-cols-3" })}
      {Choices({ name: "days", legend: t.days, options: o.days, multiple: true, cols: "grid-cols-4 sm:grid-cols-7" })}

      <div className="grid gap-6 sm:grid-cols-2">
        {Choices({ name: "transportation", legend: t.transportation, options: o.yesno, cols: "grid-cols-2" })}
        {Choices({ name: "work_authorized", legend: t.work_authorized, options: o.yesno, cols: "grid-cols-2" })}
        {Choices({ name: "pets", legend: t.pets, options: o.yesno, cols: "grid-cols-2" })}
        {Choices({ name: "languages", legend: t.languages, options: o.languages, multiple: true, cols: "grid-cols-3" })}
      </div>

      {Select({ name: "referral", label: t.referral, options: o.referral, optional: true })}

      <div>
        <Label name="about" optional>
          {t.about}
        </Label>
        <textarea rows={4} placeholder={t.aboutPlaceholder} className={`${inputClass} resize-y`} {...fieldProps("about")} />
        {errors.about && <ErrorText id={`${p}-about-error`}>{t.errors.about}</ErrorText>}
      </div>

      <div>
        <label className="flex cursor-pointer items-start gap-3 text-sm text-ink/75">
          <input
            type="checkbox"
            name="consent"
            checked={values.consent}
            onChange={e => update("consent", e.target.checked)}
            onFocus={onFirstInteraction}
            aria-invalid={errors.consent ? "true" : undefined}
            aria-describedby={describedBy("consent")}
            className="mt-0.5 size-5 shrink-0 rounded accent-brand-700"
          />
          <span>{t.consent}</span>
        </label>
        {errors.consent && <ErrorText id={`${p}-consent-error`}>{t.errors.consent}</ErrorText>}
      </div>

      {/* Honeypot for bots: hidden from people and assistive tech */}
      <div className="absolute -left-[9999px]" aria-hidden="true">
        <label htmlFor={`${p}-company`}>Company</label>
        <input id={`${p}-company`} type="text" name="company" tabIndex={-1} autoComplete="off" value={values.company} onChange={e => update("company", e.target.value)} />
      </div>

      <button
        type="submit"
        disabled={submitting}
        className="group/btn flex w-full items-center justify-center gap-2 rounded-full bg-cta px-6 py-4 text-lg font-bold text-white shadow-lg shadow-brand-900/20 transition duration-300 hover:-translate-y-0.5 hover:bg-cta-hover focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-brand-700 disabled:translate-y-0 disabled:cursor-wait disabled:opacity-80"
      >
        {submitting ? (
          <>
            <span className="size-5 animate-spin rounded-full border-2 border-white/40 border-t-white" aria-hidden="true" />
            {t.sending}
          </>
        ) : (
          <>
            {t.submit}
            <span className="transition-transform duration-300 group-hover/btn:translate-x-1">
              <Icon name="arrow-right" className="size-5" />
            </span>
          </>
        )}
      </button>

      <p className="text-center text-xs leading-relaxed text-ink/55">
        {t.privacy}
        {privacyUrl && (
          <>
            {" "}
            <a href={privacyUrl} className="font-semibold text-brand-700 underline">
              {t.privacyLink}
            </a>
            .
          </>
        )}
      </p>
    </form>
  )
}
