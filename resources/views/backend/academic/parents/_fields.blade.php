{{-- used by the parent form and by the "quick add parent" modal on the student form --}}
<x-academic.input name="first_name" label="First Name" :value="$parent->first_name" required />
<x-academic.input name="last_name" label="Last Name" :value="$parent->last_name" required />
<x-academic.input name="phone" label="Phone" type="tel" :value="$parent->phone" required />
<x-academic.input name="email" label="Email" type="email" :value="$parent->email" />
<x-academic.select name="relationship" label="Relationship" :options="\App\Models\Guardian::RELATIONSHIPS" :value="$parent->relationship" :search="false" />
<x-academic.input name="profession" label="Profession" :value="$parent->profession" />
