<?php
/**
 * What each service includes, room by room. Source: the client's sheet
 * "Dany Maid – Cleaning Services" (Nov 2026), which the client calls the single source of truth for
 * service pages, ads and quotes. Keep wording in sync with that sheet; don't add tasks it doesn't list.
 *
 * Shape per service:
 *   summary  one line (best for + scope), used on the services overview
 *   intro    lead paragraph above the checklist
 *   adds     (move only) what the tier adds on top of deep cleaning: [icon, title, text]
 *   rooms    [title, icon, items] where items is a flat list, or 'parts' => [subheading => items].
 *            An item prefixed with '+' is highlighted as added for this tier.
 *   steps    (airbnb / commercial) how the tailored scope works
 * One-time cleaning is not in the sheet, so it has no checklist (the page keeps its generic copy).
 */

function dm_service_scope($key) {
  $scopes = array(
    'recurring' => array(
      'summary' => 'Keeping the home in shape with regular visits: dusting, surfaces, floors, kitchen and bathrooms.',
      'intro'   => 'Every standard visit covers the same rooms and tasks, so you always know what to expect.',
      'rooms'   => array(
        array('title' => 'Entrance', 'icon' => 'key', 'items' => array('Floor swept and mopped', 'Furniture and decor dusted')),
        array('title' => 'Living room', 'icon' => 'home', 'items' => array('Furniture and shelves dusted', 'Carpets and rugs vacuumed', 'Floor swept and mopped', 'Tables and surfaces cleaned', 'Cushions and blankets arranged')),
        array('title' => 'Kitchen', 'icon' => 'fire', 'items' => array('Work surfaces cleaned', 'Appliance exteriors cleaned', 'Sink washed', 'Floor swept and mopped')),
        array('title' => 'Dining room', 'icon' => 'user-group', 'items' => array('Table and chairs cleaned', 'Floor vacuumed or swept')),
        array('title' => 'Bathrooms', 'icon' => 'shield-check', 'items' => array('Sink and faucets cleaned', 'Toilet disinfected', 'Shower and/or bathtub cleaned', 'Floor swept and mopped')),
        array('title' => 'Bedrooms', 'icon' => 'moon', 'items' => array('Furniture dusted', 'Floor vacuumed or swept')),
        array('title' => 'Additional areas', 'icon' => 'home', 'items' => array('Stairs cleaned', 'Railings dusted')),
        array('title' => 'Final tasks', 'icon' => 'check', 'items' => array('Trash and garbage cans emptied', 'Final review of details')),
      ),
    ),
    'deep' => array(
      'summary' => 'A first visit or a full reset: everything in a recurring visit, plus baseboards, doors, light fixtures, ceiling fans, and the stove and microwave in depth.',
      'intro'   => 'Everything in a recurring visit, plus baseboards, doors, light fixtures, ceiling fans, and the stove and microwave cleaned in depth.',
      'rooms'   => array(
        array('title' => 'Living room and common areas', 'icon' => 'home', 'parts' => array(
          'Dust and surfaces'      => array('Furniture dusted', 'Surfaces wiped clean', 'Picture frames dusted', 'Ceiling fans dusted', 'Window sills dusted'),
          'Details'                => array('Mirrors cleaned', 'Cushions and pillows fluffed', 'Cobwebs removed', 'Light fixtures and switches cleaned'),
          'Floors and circulation' => array('Baseboards and doors cleaned', 'Floors vacuumed or mopped', 'Stairs, halls and foyers cleaned'),
        )),
        array('title' => 'Kitchen', 'icon' => 'fire', 'parts' => array(
          'Appliances and cabinets'  => array('Stove deep cleaned', 'Microwave cleaned inside and out', 'Exterior of all appliances', 'Outside of cabinets cleaned'),
          'Hygiene and disinfection' => array('Countertops disinfected', 'Sinks scrubbed and disinfected', 'Trash emptied'),
          'General cleaning'         => array('General dusting', 'Cobwebs removed', 'Baseboards and doors cleaned', 'Light fixtures and switches cleaned', 'Floors vacuumed and mopped'),
        )),
        array('title' => 'Bedrooms', 'icon' => 'moon', 'parts' => array(
          'Dust'                 => array('Furniture dusted', 'Picture frames dusted', 'Ceiling fans dusted', 'Window sills dusted'),
          'Surfaces and details' => array('Surfaces wiped clean', 'Mirrors cleaned', 'Cobwebs removed'),
          'Finishes and floors'  => array('Baseboards and doors cleaned', 'Light fixtures and switches cleaned', 'Floors vacuumed or mopped'),
        )),
        array('title' => 'Bathrooms', 'icon' => 'shield-check', 'parts' => array(
          'Fixtures'                   => array('Bathtub and shower cleaned', 'Toilet disinfected', 'Sink cleaned'),
          'Glass, chrome and cabinets' => array('Mirrors and chrome cleaned', 'Glass door washed inside and out', 'Cabinets cleaned'),
          'General cleaning'           => array('Light fixtures and switches', 'Baseboards and doors', 'General dusting', 'Cobwebs removed', 'Floor cleaned and vacuumed', 'Trash emptied'),
        )),
      ),
    ),
    'move' => array(
      'summary' => 'Empty homes, before handover or move-in: everything in a deep cleaning, plus oven, refrigerator, inside of cabinets and interior windows.',
      'intro'   => 'Built for empty homes before handover or move-in: everything in a deep cleaning, plus the oven, refrigerator, inside of cabinets and interior windows.',
      'adds'    => array(
        array('window', 'Interior windows', 'Cleaned in every room'),
        array('fire', 'Oven', 'Full oven cleaning'),
        array('cube', 'Refrigerator', 'Full refrigerator cleaning'),
        array('archive-box', 'Cabinet interiors', 'Kitchen cabinets cleaned inside and out'),
        array('home', 'Trim', 'Added to baseboards and doors'),
        array('trash', 'Trash removal', 'Trash removed from every room'),
      ),
      'rooms'   => array(
        array('title' => 'Living room', 'icon' => 'home', 'items' => array('Surfaces dusted and wiped clean', '+Interior windows cleaned', 'Ceiling fans dusted', 'Cobwebs removed', 'Window sills dusted', 'Baseboards, trim and doors cleaned', 'Floors vacuumed, swept and/or mopped', 'Light fixtures and switches cleaned', 'Stairs, halls and foyers cleaned', '+Trash removed')),
        array('title' => 'Kitchen', 'icon' => 'fire', 'items' => array('Stove deep cleaned', '+Oven cleaned', '+Refrigerator cleaned', 'Exterior of all appliances', 'Microwave cleaned inside and out', 'Countertops disinfected', 'Sinks scrubbed and disinfected', '+Cabinets cleaned inside and out', 'Floors vacuumed, swept and/or mopped', 'Cobwebs removed', '+Interior windows cleaned', 'General dusting', 'Baseboards, trim and doors cleaned', 'Light fixtures and switches cleaned', 'Trash removed')),
        array('title' => 'Bedrooms', 'icon' => 'moon', 'items' => array('Surfaces dusted and wiped clean', 'Ceiling fans dusted', 'Cobwebs removed', 'Window sills dusted', '+Interior windows cleaned', 'Baseboards, trim and doors cleaned', 'Light fixtures and switches cleaned', 'Floors vacuumed, swept and/or mopped', '+Trash removed')),
        array('title' => 'Bathrooms', 'icon' => 'shield-check', 'items' => array('Bathtub and shower cleaned', 'Toilet disinfected', 'Mirrors and chrome cleaned', 'Glass door washed inside and out', 'Cabinets cleaned', 'Light fixtures and switches cleaned', 'Sink cleaned', 'Floors vacuumed, swept and/or mopped', 'Baseboards, trim and doors cleaned', '+Interior windows cleaned', 'General dusting', 'Cobwebs removed', 'Trash removed')),
      ),
    ),
    'airbnb' => array(
      'summary' => 'Turnovers between guests, built on the host’s own checklist.',
      'intro'   => 'Built on your own checklist. Every rental is set up differently, so we clean to the list you already use with your guests.',
      'steps'   => array('The host shares their checklist', 'We clean to it on every turnover between guests', 'Final review of details before the next check-in'),
    ),
    'commercial' => array(
      'summary' => 'Offices, stores and workspaces, with a plan tailored to the client’s requirements.',
      'intro'   => 'Scoped to each client’s requirements. We plan the cleaning around your space, your schedule and the way your business works.',
      'steps'   => array('We review the space and its requirements', 'We define a tailored scope and schedule', 'Cleaning is delivered to the agreed plan'),
    ),
  );
  return isset($scopes[$key]) ? $scopes[$key] : null;
}

// Scope comparison across the three residential tiers (sheet p.13). Airbnb and commercial vary by client.
function dm_scope_comparison() {
  return array(
    'tiers' => array('recurring' => 'Recurring', 'deep' => 'Deep', 'move' => 'Move-in / out'),
    'rows'  => array(
      array('Dusting and surfaces', 'recurring'),
      array('Floors', 'recurring'),
      array('Toilet disinfected', 'recurring'),
      array('Baseboards and doors', 'deep'),
      array('Light fixtures and switches', 'deep'),
      array('Ceiling fans and cobwebs', 'deep'),
      array('Stove and microwave in depth', 'deep'),
      array('Oven and refrigerator', 'move'),
      array('Cabinet interiors', 'move'),
      array('Interior windows', 'move'),
    ),
  );
}

// Counts every task in a service's rooms (e.g. "12 tasks" labels).
function dm_scope_room_count($room) {
  if (!empty($room['parts'])) {
    return array_sum(array_map('count', $room['parts']));
  }
  return count($room['items']);
}
