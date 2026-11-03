import React, { useRef, useState } from "react"
import Icon from "./Icon"
import { track } from "../analytics"

const CONTACT_METHODS = [
  { value: "call", label: "Phone call" },
  { value: "text", label: "Text" },
  { value: "email", label: "Email" }
]

const EMPTY = { name: "", email: "", phone: "", zip: "", service: "", contact_method: "call", sms_consent: false, message: "", company: "" }

const inputClass =
  "mt-2 block w-full rounded-xl border-0 bg-cream px-4 py-3 text-base text-ink ring-1 ring-brand-900/15 transition placeholder:text-ink/40 focus:bg-white focus:outline-none focus:ring-2 focus:ring-brand-600 aria-[invalid=true]:bg-red-50 aria-[invalid=true]:ring-red-500"

// Same rules as dm_validate_contact() in inc/contact.php.
function validate(values) {
  const errors = {}
  const digits = values.phone.replace(/\D/g, "")
  if (values.name.trim().length < 2) errors.name = "Please enter your name."
  if (!/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(values.email.trim())) errors.email = "Please enter a valid email address."
  if (values.phone && !/^1?\d{10}$/.test(digits)) errors.phone = "Please enter a 10-digit phone number."
  if (!/^\d{5}$/.test(values.zip.trim())) errors.zip = "Please enter a 5-digit ZIP code."
  if (!values.service) errors.service = "Please choose a service."
  if (values.contact_method !== "email" && !digits) errors.phone = "Please add a phone number so we can call or text you."
  else if (values.contact_method === "text" && !values.sms_consent) errors.sms_consent = "Please agree to receive text messages, or choose another contact method."
  if (values.message.length > 2000) errors.message = "Please keep your message under 2,000 characters."
  return errors
}

function readTracking() {
  let utm = {}
  try {
    utm = JSON.parse(sessionStorage.getItem("dm_utm")) || {}
  } catch (err) {}
  return { ...utm, page_path: window.location.pathname }
}

function Field({ id, label, optional, error, hint, children }) {
  return (
    <div>
      <label htmlFor={id} className="flex items-baseline justify-between text-sm font-bold text-brand-950">
        {label}
        {optional && <span className="text-xs font-semibold text-ink/50">Optional</span>}
      </label>
      {children}
      {hint && !error && (
        <p id={`${id}-hint`} className="mt-1.5 text-xs text-ink/60">
          {hint}
        </p>
      )}
      {error && (
        <p id={`${id}-error`} className="mt-1.5 flex items-center gap-1.5 text-sm font-semibold text-red-700">
          <span aria-hidden="true">!</span> {error}
        </p>
      )}
    </div>
  )
}

// formId comes from the mount element's data-form-id (see src/index.js)
export default function ContactForm({ data, formId = "home_contact" }) {
  const { services, business, privacyUrl, contact } = data
  const serviceFromUrl = new URLSearchParams(window.location.search).get("service")
  const initialService = services.some(s => s.key === serviceFromUrl) ? serviceFromUrl : ""

  const [values, setValues] = useState({ ...EMPTY, service: initialService })
  const [errors, setErrors] = useState({})
  const [status, setStatus] = useState("idle") // idle | submitting | success | error
  const [serverMessage, setServerMessage] = useState("")
  const [reference, setReference] = useState(null)
  const startedAt = useRef(Date.now())
  const started = useRef(false)
  const formRef = useRef(null)

  const serviceOptions = [...services.map(s => ({ value: s.key, label: s.title })), { value: "not-sure", label: "Not sure yet" }]

  function onFirstInteraction() {
    if (started.current) return
    started.current = true
    track("form_start", { form_id: formId, service_type: values.service || "unknown" })
  }

  function update(name, value) {
    setValues(prev => ({ ...prev, [name]: value }))
    if (errors[name]) setErrors(prev => ({ ...prev, [name]: undefined }))
  }

  function fieldProps(name) {
    return {
      id: `dm-cf-${name}`,
      name,
      value: values[name],
      onChange: e => update(name, e.target.value),
      onFocus: onFirstInteraction,
      "aria-invalid": errors[name] ? "true" : undefined,
      "aria-describedby": errors[name] ? `dm-cf-${name}-error` : undefined
    }
  }

  function showErrors(found) {
    setErrors(found)
    Object.entries(found).forEach(([field, reason]) => track("form_error", { form_id: formId, field_type: field, reason }))
    const first = Object.keys(found)[0]
    // Wait for the error state to render, then move focus to the first problem.
    requestAnimationFrame(() => formRef.current?.querySelector(`[name="${first}"]`)?.focus())
  }

  async function onSubmit(e) {
    e.preventDefault()
    const found = validate(values)
    if (Object.keys(found).length) return showErrors(found)

    setStatus("submitting")
    setServerMessage("")
    try {
      const response = await fetch(contact.endpoint, {
        method: "POST",
        headers: { "Content-Type": "application/json" },
        body: JSON.stringify({ ...values, elapsed: Date.now() - startedAt.current, tracking: readTracking() })
      })
      const body = await response.json().catch(() => ({}))

      if (response.ok && body.ok) {
        setReference(body.reference)
        setStatus("success")
        track("generate_lead", { form_id: formId, service_type: values.service })
        formRef.current?.closest("section")?.scrollIntoView({ behavior: "smooth", block: "start" })
        return
      }
      if (body.data?.fields) {
        setStatus("idle")
        return showErrors(body.data.fields)
      }
      setServerMessage(body.message || "")
      setStatus("error")
    } catch (err) {
      setStatus("error")
    }
  }

  if (status === "success") {
    return (
      <div className="flex min-h-140 animate-fade-up flex-col items-center justify-center text-center" role="status">
        <span className="relative flex size-20 items-center justify-center">
          <span className="absolute inline-flex size-full animate-ping rounded-full bg-leaf-300 opacity-40" />
          <span className="relative flex size-20 items-center justify-center rounded-full bg-leaf-500 text-brand-950">
            <Icon name="check" className="size-10" />
          </span>
        </span>
        <h3 className="mt-8 font-display text-3xl font-semibold text-brand-950">Request received</h3>
        <p className="mt-4 max-w-md text-lg leading-relaxed text-ink/75">{contact.successMessage}</p>
        {reference && (
          <p className="mt-6 rounded-full bg-cream px-5 py-2 text-sm font-semibold text-brand-900">
            Your reference: <span className="font-extrabold">{reference}</span>
          </p>
        )}
        <p className="mt-8 text-sm text-ink/60">
          Need to add something? Call us at{" "}
          <a href={business.phoneHref} data-location="contact_success" className="font-bold text-brand-700 hover:underline">
            {business.phone}
          </a>
        </p>
      </div>
    )
  }

  const submitting = status === "submitting"
  const showSmsConsent = values.contact_method === "text" || values.phone.trim() !== ""

  return (
    <form ref={formRef} onSubmit={onSubmit} noValidate aria-labelledby="dm-cf-title" className="space-y-5">
      <div>
        <h3 id="dm-cf-title" className="font-display text-2xl font-semibold text-brand-950">
          Request your personalized quote
        </h3>
        <p className="mt-1 text-sm text-ink/60">Pricing depends on your home, its condition, and your service needs. It takes about a minute.</p>
      </div>

      {status === "error" && (
        <div role="alert" className="animate-slide-down rounded-2xl bg-red-50 p-4 text-sm text-red-800 ring-1 ring-red-200">
          <p className="font-bold">{serverMessage || "We couldn’t send your request."}</p>
          <p className="mt-1">
            Your details are still here—please try again, or reach us directly at{" "}
            <a href={business.phoneHref} data-location="contact_error" className="font-bold underline">
              {business.phone}
            </a>
            {business.email && (
              <>
                {" "}or{" "}
                <a href={`mailto:${business.email}`} className="font-bold underline">
                  {business.email}
                </a>
              </>
            )}
            .
          </p>
        </div>
      )}

      <div className="grid gap-5 sm:grid-cols-2">
        <Field id="dm-cf-name" label="Full name" error={errors.name}>
          <input type="text" autoComplete="name" className={inputClass} {...fieldProps("name")} />
        </Field>
        <Field id="dm-cf-email" label="Email" error={errors.email}>
          <input type="email" autoComplete="email" inputMode="email" className={inputClass} {...fieldProps("email")} />
        </Field>
        <Field id="dm-cf-phone" label="Mobile phone" optional={values.contact_method === "email"} error={errors.phone}>
          <input type="tel" autoComplete="tel" inputMode="tel" placeholder="(916) 555-0123" className={inputClass} {...fieldProps("phone")} />
        </Field>
        <Field id="dm-cf-zip" label="ZIP code" error={errors.zip} hint="We’ll confirm we serve your address.">
          <input type="text" autoComplete="postal-code" inputMode="numeric" maxLength={5} placeholder="95610" className={inputClass} {...fieldProps("zip")} aria-describedby={errors.zip ? "dm-cf-zip-error" : "dm-cf-zip-hint"} />
        </Field>
      </div>

      <Field id="dm-cf-service" label="Service you’re interested in" error={errors.service}>
        <div className="relative">
          <select className={`${inputClass} appearance-none pr-12`} {...fieldProps("service")}>
            <option value="">Choose a service…</option>
            {serviceOptions.map(option => (
              <option key={option.value} value={option.value}>
                {option.label}
              </option>
            ))}
          </select>
          <Icon name="chevron-down" className="pointer-events-none absolute right-4 top-1/2 size-5 -translate-y-1/2 text-brand-700" />
        </div>
      </Field>

      <fieldset>
        <legend className="text-sm font-bold text-brand-950">How should we contact you?</legend>
        <div className="mt-2 grid grid-cols-3 gap-2">
          {CONTACT_METHODS.map(method => (
            <label key={method.value} className="cursor-pointer">
              <input type="radio" name="contact_method" value={method.value} checked={values.contact_method === method.value} onChange={e => update("contact_method", e.target.value)} onFocus={onFirstInteraction} className="peer sr-only" />
              <span className="flex items-center justify-center rounded-xl bg-cream px-3 py-3 text-sm font-bold text-brand-900 ring-1 ring-brand-900/15 transition peer-checked:bg-brand-700 peer-checked:text-white peer-checked:ring-brand-700 peer-focus-visible:outline-2 peer-focus-visible:outline-offset-2 peer-focus-visible:outline-brand-700 hover:ring-brand-600">
                {method.label}
              </span>
            </label>
          ))}
        </div>
      </fieldset>

      <Field id="dm-cf-message" label="Tell us about your home" optional error={errors.message}>
        <textarea rows={4} placeholder="Bedrooms, bathrooms, preferred timing, pets, anything we should know…" className={`${inputClass} resize-y`} {...fieldProps("message")} />
      </Field>

      {showSmsConsent && (
        <div className="animate-slide-down">
          <label className="flex cursor-pointer items-start gap-3 text-sm text-ink/75">
            <input
              type="checkbox"
              name="sms_consent"
              checked={values.sms_consent}
              onChange={e => update("sms_consent", e.target.checked)}
              aria-invalid={errors.sms_consent ? "true" : undefined}
              aria-describedby={errors.sms_consent ? "dm-cf-sms_consent-error" : undefined}
              className="mt-0.5 size-5 shrink-0 rounded accent-brand-700"
            />
            <span>I agree to receive text messages from Dany Maid about my request. Message and data rates may apply. Reply STOP to opt out.</span>
          </label>
          {errors.sms_consent && (
            <p id="dm-cf-sms_consent-error" className="mt-1.5 text-sm font-semibold text-red-700">
              {errors.sms_consent}
            </p>
          )}
        </div>
      )}

      {/* Honeypot for bots: hidden from people and assistive tech */}
      <div className="absolute -left-[9999px]" aria-hidden="true">
        <label htmlFor="dm-cf-company">Company</label>
        <input id="dm-cf-company" type="text" name="company" tabIndex={-1} autoComplete="off" value={values.company} onChange={e => update("company", e.target.value)} />
      </div>

      <button
        type="submit"
        disabled={submitting}
        className="group/btn flex w-full items-center justify-center gap-2 rounded-full bg-brand-700 px-6 py-4 text-lg font-bold text-white shadow-lg shadow-brand-900/20 transition duration-300 hover:-translate-y-0.5 hover:bg-brand-800 focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-brand-700 disabled:translate-y-0 disabled:cursor-wait disabled:opacity-80"
      >
        {submitting ? (
          <>
            <span className="size-5 animate-spin rounded-full border-2 border-white/40 border-t-white" aria-hidden="true" />
            Sending…
          </>
        ) : (
          <>
            Send My Request
            <span className="transition-transform duration-300 group-hover/btn:translate-x-1">
              <Icon name="arrow-right" className="size-5" />
            </span>
          </>
        )}
      </button>

      <p className="text-center text-xs leading-relaxed text-ink/55">
        This is a request, not a confirmed appointment. We’ll use your details only to respond to you.
        {privacyUrl && (
          <>
            {" "}
            See our{" "}
            <a href={privacyUrl} className="font-semibold text-brand-700 underline">
              Privacy Policy
            </a>
            .
          </>
        )}
      </p>
    </form>
  )
}
