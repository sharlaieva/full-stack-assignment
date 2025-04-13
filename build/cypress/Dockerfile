FROM cypress/base
WORKDIR /app

COPY ../../cypress/package.json .
COPY ../../cypress/package-lock.json .

ENV CI=1
RUN npm ci
RUN npx cypress verify
