#!/usr/bin/env bash
set -euo pipefail
cd "$(dirname "${BASH_SOURCE[0]}")"

IMAGE="ewalch-prod_php"
SHA="$(git rev-parse --short HEAD)"
DIRTY=""
[ -z "$(git status --porcelain)" ] || DIRTY="-dirty"
TAG="${SHA}${DIRTY}"
ARCHIVE="ewalch_${TAG}.tar.zst"
KEEP=3

echo "==> Building ${IMAGE}:${TAG} (tagged latest + ${TAG})"
DOCKER_BUILDKIT=1 docker build \
    --target runtime \
    --tag "${IMAGE}:latest" \
    --tag "${IMAGE}:${TAG}" \
    .

echo "==> Saving image to ${ARCHIVE}"
docker save "${IMAGE}:latest" "${IMAGE}:${TAG}" | zstd -T0 -3 -q -o "${ARCHIVE}"

echo "${TAG}" > .last_build
du -h "${ARCHIVE}"

echo "==> Cleaning up old archives (keeping last ${KEEP})"
ls -t ewalch_*.tar.zst ewalch_*.tar.gz 2>/dev/null | tail -n "+$((KEEP + 1))" | xargs -r rm -v

echo "==> Done. Run ./deploy.sh to ship ${ARCHIVE}"
