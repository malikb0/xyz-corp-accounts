#!/usr/bin/env bash
#
# End-to-end smoke test for xyz-corp-accounts.
# Logs in with the seeded admin user and requests every module, asserting that
# each page renders without a PHP error/exception marker.
#
# Usage: scripts/smoke-test.sh [BASE_URL]
# Exit code: 0 = all good, 1 = at least one failure.

set -u

BASE_URL="${1:-${APP_BASE_URL:-http://localhost:8080}}"
BASE_URL="${BASE_URL%/}"
USERNAME="${SMOKE_USER:-admin}"
PASSWORD="${SMOKE_PASS:-admin123}"

COOKIE_JAR="$(mktemp)"
trap 'rm -f "$COOKIE_JAR"' EXIT

CONTROLLERS=(
  Welcome Accounts Arabic_description Data_reports Employees_data Expenses
  Get_report Investments Invoice Order_items Orders Owner_transactions Profits
  Rental_equipments Salary_slip Transactions Trips Upload_invoices
  Vat_invoice Vat_invoice_1 Vehicles_data Vendor_contracts Vendor_items
)

fail=0
check() {
  local label="$1" url="$2" expect="${3:-200}"
  local body http
  body="$(mktemp)"
  http="$(curl -sS -b "$COOKIE_JAR" -o "$body" -w '%{http_code}' "$url")"
  if [ "$http" != "$expect" ]; then
    echo "  FAIL  $label (HTTP $http, expected $expect)"
    fail=1
  elif grep -qiE 'PHP Error|uncaught Exception|Fatal error' "$body"; then
    local msg
    msg="$(grep -m1 -oE 'Message:  [^<]+' "$body" | head -1)"
    echo "  FAIL  $label (PHP error: ${msg:-see body})"
    fail=1
  else
    echo "  ok    $label"
  fi
  rm -f "$body"
}

echo "Base URL: $BASE_URL"
echo
echo "Login"
login_body="$(mktemp)"
login_http="$(curl -sS -c "$COOKIE_JAR" -b "$COOKIE_JAR" \
  -o "$login_body" -w '%{http_code}' \
  -d "username=$USERNAME&password=$PASSWORD&submit=Login" \
  "$BASE_URL/index.php/User_Authentication/user_login_process")"
if [ "$login_http" != "200" ]; then
  echo "  FAIL  login (HTTP $login_http)"
  echo "Cannot continue without a session."
  rm -f "$login_body"
  exit 1
fi
# The login controller renders the admin dashboard on success.
if grep -q "Dashboard" "$login_body"; then
  echo "  ok    login (dashboard reached)"
else
  echo "  FAIL  login (dashboard not reached)"
  fail=1
fi
rm -f "$login_body"

echo
echo "Modules"
for c in "${CONTROLLERS[@]}"; do
  check "$c" "$BASE_URL/index.php/$c"
done

echo
if [ "$fail" -eq 0 ]; then
  echo "SMOKE TEST PASSED"
else
  echo "SMOKE TEST FAILED"
fi
exit "$fail"
